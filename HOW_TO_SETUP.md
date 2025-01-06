# alas-quadros

POS of Alas Quadros

# How to setup and run the POS

1. Run the XAMPP Control Panel
2. Start the Apache and MySQL
3. Open CMD
4. Enter the command `ipconfig`
5. Find `IPv4 Address. . . . . . . . . . . : 192.168.1.25`
6. Copy the IPv4 Address (192.168.1.25)
7. Open VSCode
8. Find `vite.config.js`
9. Paste the IPv4 Address to `host: '192.168.1.25'`
10. Save the file (Ctrl + S)
11. Open the terminal by clicking Ctrl + J
12. Enter the command `cd pos`
13. Enter the command `npm run dev --host=192.168.1.25 --port=5173`
14. Hit Ctrl + Shift + ` to open a new terminal
15. Enter the command `cd pos`
16. php artisan serve --host=192.168.1.25 --port=8000
17. Open `192.168.1.25` in multiple devices

GOODLUCK ALAS!
