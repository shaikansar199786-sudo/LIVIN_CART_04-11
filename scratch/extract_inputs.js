const fs = require('fs');
const readline = require('readline');

const logPath = 'C:/Users/Shaik Ansar/.gemini/antigravity-ide/brain/02dfc047-0005-4274-b0c9-69237ca9d2b8/.system_generated/logs/transcript.jsonl';

const rl = readline.createInterface({
  input: fs.createReadStream(logPath)
});

rl.on('line', (line) => {
  try {
    const obj = JSON.parse(line);
    if (obj.type === 'USER_INPUT') {
      const match = obj.content && obj.content.match(/<USER_REQUEST>([\s\S]*?)<\/USER_REQUEST>/);
      console.log('=== Step ' + obj.step_index + ' ===');
      console.log(match ? match[1].trim() : obj.content.slice(0, 150));
    }
  } catch (e) {}
});
