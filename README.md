# Weather emulator for loxone miniserver
## Configuration of the forecast.php file
Set the variables below as recommended:
- `$city` - English name of your city
- `$country` - English name of your country
- `$utc` - set your time zone e.g. "UTC+00.00"
- `$userKey` - paste your key here from https://openweathermap.org/
<br>You will need a configured account for "One Call API 3.0".

Set the timezone in `date_default_timezone_set();` using the value from https://www.php.net/manual/en/timezones.php

## Apache2 configuration
### Apache2 installation and configuration
System update
```bash
sudo apt-get update
sudo apt-get upgrade
```
Installing apache2
```bash
sudo apt install apache2 -y
```
Installing php
```bash
sudo apt install php7.4 libapache2-mod-php7.4 php7.4-mbstring php7.4-mysql php7.4-curl php7.4-gd php7.4-zip -y
```

### Apache2 configuration
Create a directory
```bash
sudo mkdir -p /var/www/loxone
sudo chown -R www-data:www-data /var/www/loxone
```
Add the `loxone.php` and `.htaccess` files to the `/var/www/loxone` directory

Add the following line at the top of ports.conf
```
Listen 6066
```

Add the `loxone.conf` file to the `/etc/apache2/sites-available/` directory

Create a symbolic link
```bash
sudo a2ensite loxone.conf
```

Restart apache2
```bash
sudo systemctl reload apache2
```

## DNS configuration
Set the static DNS record for the ip address (where the apache2 server with the forecast.php file is located) to "weather.loxone.com". Then enter the IP address of the configured DNS server in the Loxone Miniserver configuration.

## Author information
The creator of the script is Dominik Krzywański. <br>
Developer website: [WolfRor](https://wolfror.com)

---

# Konfiguracja serwera pogodowego dla loxone miniserwer
## Konfiguracja pliku forecast.php
Ustaw poniższe zmienne zgodnie z zaleceniami:
- `$city` - angielska nazwa twojego miasta
- `$country` - angielska nazwa twojego kraju
- `$utc` - ustaw swoją strefę czasową np "UTC+00.00"
- `$userKey` - wklej tutaj swój klucz ze strony https://openweathermap.org/
<br>Będziesz potrzebował skonfigurowanego konta dla "One Call API 3.0".

Ustaw strefę czasową w `date_default_timezone_set();` używając wartości ze strony https://www.php.net/manual/en/timezones.php

## Instalacja oraz konfiguracja apache2
### Instalacja apache2
Aktualizacja systemu
```bash
sudo apt-get update
sudo apt-get upgrade
```
Instalacja apache2
```bash
sudo apt install apache2 -y
```
Instalacja php
```bash
sudo apt install php7.4 libapache2-mod-php7.4 php7.4-mbstring php7.4-mysql php7.4-curl php7.4-gd php7.4-zip -y
```

### Konfiguracja apache2
Stwórz katalog
```bash
sudo mkdir -p /var/www/loxone
sudo chown -R www-data:www-data /var/www/loxone
```
Dodaj plik `loxone.php` oraz `.htaccess` do katalogu `/var/www/loxone`

Dodaj poniższą linijkę na górze pliku ports.conf
```
Listen 6066
```

Dodaj plik `loxone.conf` do katalogu `/etc/apache2/sites-available/`

Stwórz dowiązanie symboliczne
```bash
sudo a2ensite loxone.conf
```

Zrestartuj apache2
```bash
sudo systemctl reload apache2
```

## Konfiguracja DNS
Należy ustawić statyczny rekord DNS dla adresu ip (na którym znajduje się serwer apache2 z plikiem forecast.php) na "weather.loxone.com". Następnie podać adres ip skonfigurowanego serwera DNS w konfiguracji miniserwera Loxone.

## Informacje o autorze
Twórcą skryptu jest Dominik Krzywański. <br>
Witryna twórcy: [WolfRor](https://wolfror.com)