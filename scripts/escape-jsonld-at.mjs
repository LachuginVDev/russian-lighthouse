import fs from 'node:fs';
import path from 'node:path';

function walk(dir, files = []) {
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) walk(full, files);
    else if (full.endsWith('.blade.php')) files.push(full);
  }
  return files;
}

let updated = 0;
for (const file of walk('resources/views')) {
  const original = fs.readFileSync(file, 'utf8');
  let next = original
    .replaceAll('"@context"', '"@@context"')
    .replaceAll('"@type"', '"@@type"')
    .replaceAll('"@id"', '"@@id"')
    .replaceAll('"@@@@context"', '"@@context"')
    .replaceAll('"@@@@type"', '"@@type"')
    .replaceAll('"@@@@id"', '"@@id"');

  if (next !== original) {
    fs.writeFileSync(file, next);
    updated += 1;
    console.log('fixed', file);
  }
}

console.log('files updated:', updated);
