import { exec } from "child_process";
import path from "path";
import { fileURLToPath } from "url";
import { dirname } from "path";
import fs from "fs";
import os from "os";

// Fix __dirname in ESM
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Define MySQL credentials
const mysqldumpPath = `"C:\\PHP\\8.2.12\\mysql\\bin\\mysqldump.exe"`;
const dbUser = "root";
const dbPassword = "";
const dbName = "alas_quadros";

// Dynamically determine the Desktop directory
const desktopDir = path.join(os.homedir(), "Desktop");
const backupDir = path.join(desktopDir, "ALAS_QUADROS_DATA_BACKUP");

// Ensure backup directory exists
if (!fs.existsSync(backupDir)) {
  fs.mkdirSync(backupDir, { recursive: true });
  console.log(`📁 Created backup directory: ${backupDir}`);
}

// Define backup file path
const backupFile = path.join(
  backupDir,
  `alas_quadros_${new Date().toISOString().replace(/[:.]/g, "-")}.sql`
);

// Construct the command
const command = `${mysqldumpPath} --user=${dbUser} --password=${dbPassword} --protocol=socket ${dbName} > "${backupFile}"`;

console.log("Running backup command:", command);

// Execute the command
exec(command, (error, stdout, stderr) => {
  if (error) {
    console.error(`❌ Backup failed: ${error.message}`);
    return;
  }
  if (stderr) {
    console.error(`⚠ Backup error: ${stderr}`);
    return;
  }
  console.log(`✅ Backup completed successfully! File saved to: ${backupFile}`);
});
