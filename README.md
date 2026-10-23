# Arduino-Based Fire Truck Refill and Incident Monitoring System
BFP San Carlos City — Full System (Website + Database + Arduino Bridge)

This package contains everything from Chapters 1-3 turned into a working
prototype: the citizen portal, admin dashboard, MySQL database, the
Arduino sketch, and the Python bridge script that connects the two.

## What's in this folder

```
fdmrs_system/
├── index.php                  Landing page
├── setup_admin.php            Run ONCE to create your first admin account
├── config/database.sample.php DB settings template (copy as database.php)
├── database/schema.sql        Full database schema (import this into MySQL)
├── includes/                  Shared PHP (auth, helper functions)
├── citizen/                   Citizen portal (register, login, report, status)
├── admin/                     Admin dashboard (incidents, refill control,
│                               stations, vehicles, personnel, notifications, reports)
├── api/                       Endpoints the Arduino bridge talks to
├── assets/css/style.css       All styling
├── bridge/arduino_bridge.py   Connects the Arduino to the website over USB
└── arduino/                   The Arduino Uno sketch (from earlier chapters)
```

## 1. Set up the web server (XAMPP)

1. Install [XAMPP](https://www.apachefriends.org/) if you don't have it.
2. Copy the entire `fdmrs_system` folder into `htdocs`
   (e.g. `C:\xampp\htdocs\fdmrs_system` on Windows).
3. Copy `config/database.sample.php` to `config/database.php`
   (the real `database.php` is git-ignored so credentials never
   get committed — cloning from GitHub means you must do this step).
4. Start **Apache** and **MySQL** in the XAMPP Control Panel.

## 2. Create the database

1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Click **Import**, choose `database/schema.sql`, and run it.
   This creates the `fdmrs_db` database with all 7 tables (users,
   incidents, stations, vehicles, personnel, refill_logs, notifications)
   and seeds one station and one vehicle.
3. If your MySQL has a root password (most XAMPP installs don't by
   default), edit `config/database.php` and fill in `DB_PASS`.

## 3. Create your first admin account

1. In your browser, go to `http://localhost/fdmrs_system/setup_admin.php`.
2. Fill in a username, full name, and password.
3. **Delete `setup_admin.php` afterward** — it's only meant to be run once.

## 4. Try the website

- Visit `http://localhost/fdmrs_system/` for the landing page.
- **Citizen side**: register an account, submit a test incident report.
  This immediately queues an automatic refill command (Chapters 1-3's
  auto-trigger behavior) — you'll see it appear in the admin dashboard
  even before the Arduino is connected.
- **Admin side**: log in with the account from step 3. You can manage
  stations/vehicles/personnel, manually start/stop a refill, and watch
  incidents and refill activity update.

At this point the website is fully functional on its own — the refill
"commands" just sit queued in the database until the bridge script picks
them up. Connecting the Arduino is the next step.

## 5. Connect the Arduino

1. Wire your Arduino Uno as described in the wiring diagram and build
   tutorial from earlier (pump relay on D7, valve relay on D8, LEDs on
   D4/D5/D6, button on D2, buzzer on D9).
2. Open `arduino/FireTruckRefillControl/FireTruckRefillControl.ino` in
   the Arduino IDE and upload it to the Uno.
3. Close the Arduino IDE's Serial Monitor (it locks the USB port — the
   bridge script needs exclusive access).

## 6. Run the bridge script

This is what actually connects your website to the physical hardware.

1. Install Python 3 if you don't have it.
2. Install dependencies:
   ```
   cd bridge
   pip install -r requirements.txt
   ```
3. Open `arduino_bridge.py` and edit the top of the file:
   - `SERIAL_PORT` — find this in the Arduino IDE under **Tools > Port**
     (e.g. `COM3` on Windows, `/dev/ttyACM0` on Linux/Mac).
   - `WEB_BASE_URL` — leave as `http://localhost/fdmrs_system` if
     everything is running on the same computer.
4. Run it:
   ```
   python arduino_bridge.py
   ```
5. Leave this running. Every 2 seconds it checks the website for a
   queued refill command, sends it to the Arduino, and reports back
   what the Arduino says (started, stopped, timed out) so the website
   stays in sync.

## 7. End-to-end test

1. With the bridge script running and the Arduino connected, submit a
   new incident report from the citizen portal.
2. Within a couple of seconds, the bridge script's console should print
   `[send] START (refill #...)`, and the pump relay should click on.
3. The admin dashboard's Refill Control page will show the vehicle as
   "Refilling."
4. Click **Stop Refill** in the admin dashboard — the bridge script
   should pick this up and send `STOP` to the Arduino within a couple
   of seconds.

## Important notes before your defense

- **Change `BRIDGE_API_KEY`** in `api/_api_auth.php` and
  `bridge/arduino_bridge.py` (they must match) before showing this to
  anyone outside your group — right now it's a placeholder value.
- The **physical button on the Arduino** works independently of the
  website (this is intentional — see Chapter 1's Scope). If someone
  presses it directly, the bridge script will print a warning that it
  can't report that event back to the website, since no web-side
  refill_id exists for a locally-triggered refill. This is expected
  behavior, not a bug.
- If `pending_command.php` or `update_status.php` seem unreachable,
  double-check `WEB_BASE_URL` in the bridge script matches how you
  access the site in your browser.
