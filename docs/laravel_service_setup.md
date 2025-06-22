# Running POSDEMO as a Background Service

This guide outlines how to start the Laravel application automatically after a reboot, build front-end assets, clear caches, and serve the app securely with Nginx and SSL.

## 1. Build CSS and JS
Use the helper script `scripts/bootstrap_laravel.sh` to install dependencies and compile assets for each module. Run it once during deployment and whenever assets change:

```bash
bash scripts/bootstrap_laravel.sh
```

## 2. Systemd Service
Create `/etc/systemd/system/posdemo.service` with the contents below. Adjust paths if the project resides elsewhere.

```ini
[Unit]
Description=POSDEMO Laravel Service
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/posdemo
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3
ExecStartPost=/usr/bin/bash /var/www/posdemo/scripts/bootstrap_laravel.sh
Restart=always

[Install]
WantedBy=multi-user.target
```

Enable and start the service:

```bash
sudo systemctl daemon-reload
sudo systemctl enable posdemo.service
sudo systemctl start posdemo.service
```

## 3. Nginx and SSL
Install Nginx and configure it to serve the `public/` directory. A minimal configuration looks like:

```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/posdemo/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
    }
}
```

For HTTPS with Let's Encrypt:

```bash
sudo apt-get install certbot python3-certbot-nginx
sudo certbot --nginx -d example.com
```

Certbot will update the Nginx configuration to include TLS certificates and set up automatic renewal.

Once configured, Nginx starts automatically on boot, and `posdemo.service` ensures Laravel queues and caches are prepared after each reboot.
