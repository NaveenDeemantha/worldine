const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

async function processDirectory(dir) {
    const entries = fs.readdirSync(dir, { withFileTypes: true });
    for (const entry of entries) {
        const fullPath = path.join(dir, entry.name);
        if (entry.isDirectory()) {
            await processDirectory(fullPath);
        } else if (entry.isFile()) {
            const ext = path.extname(entry.name).toLowerCase();
            if (['.jpg', '.jpeg', '.png', '.webp'].includes(ext)) {
                const stats = fs.statSync(fullPath);
                if (stats.size > 200 * 1024 || entry.name.includes('worldineback')) {
                    console.log(`Optimizing: ${fullPath} (${(stats.size / 1024 / 1024).toFixed(2)} MB)`);
                    try {
                        const inputBuffer = fs.readFileSync(fullPath);
                        const image = sharp(inputBuffer);
                        const metadata = await image.metadata();

                        let pipeline = sharp(inputBuffer);
                        if (metadata.width > 1600 || metadata.height > 1600) {
                            pipeline = pipeline.resize(1600, 1600, {
                                fit: 'inside',
                                withoutEnlargement: true
                            });
                        }

                        let outputBuffer;
                        if (ext === '.png' && !entry.name.includes('worldineback')) {
                            outputBuffer = await pipeline.png({ quality: 80, compressionLevel: 8 }).toBuffer();
                        } else if (ext === '.webp') {
                            outputBuffer = await pipeline.webp({ quality: 80 }).toBuffer();
                        } else {
                            outputBuffer = await pipeline.jpeg({ quality: 80, mozjpeg: true }).toBuffer();
                        }

                        // If worldineback.png, also generate worldineback.webp!
                        if (entry.name === 'worldineback.png') {
                            const webpPath = path.join(dir, 'worldineback.webp');
                            const webpBuffer = await sharp(inputBuffer)
                                .resize(1920, 1080, { fit: 'inside', withoutEnlargement: true })
                                .webp({ quality: 82 })
                                .toBuffer();
                            fs.writeFileSync(webpPath, webpBuffer);
                            console.log(`Created WebP: ${webpPath} (${(webpBuffer.length / 1024).toFixed(1)} KB)`);
                        }

                        fs.writeFileSync(fullPath, outputBuffer);
                        console.log(`-> Reduced to ${(outputBuffer.length / 1024).toFixed(1)} KB (-${((1 - outputBuffer.length / stats.size) * 100).toFixed(0)}%)`);
                    } catch (err) {
                        console.error(`Failed to optimize ${fullPath}:`, err.message);
                    }
                }
            }
        }
    }
}

const targetDir = path.join(__dirname, 'public', 'images');
console.log(`Starting image optimization in ${targetDir}...`);
processDirectory(targetDir).then(() => {
    console.log('All images optimized successfully!');
});
