### Запуск проекта(из директорий проекта): `docker-compose up -d`
Если внесли правки во фронт нужно перебилдить контейнер: `docker-compose up -d --build`
### Остановить проект(из директории проекта): `docker-compose down`
### удалить образ с сервера и все процессы: `docker system prune -a` если еще будут какие-то нюансы можно почитать [тут](https://www.digitalocean.com/community/tutorials/how-to-remove-docker-images-containers-and-volumes)

## WordPress API admin panel
> https://<domain.com>/wp-api/wp-admin
> 


### /docker-compose.yml
> конфиг внутри файла `docker-compose.yml` 
добавлять домен сайта 39 строка ( https-portal environment DOMAINS) чтобы запускать для дев, закомментируйте эту строку, она только для прод.

> Настройка доступов к wordpress 74-77 строка (wordpress environment) можно не менять

## Директории
### /db-data 
> тут находятся файлы DB, так-же есть phpMyAdmin (http:// не https!) порт :8080 (пример, заходить http://site.com:8080) - можно изменить в `docker-compose.yml` строка 60, логин - пароль так-же можно зименять в конфиге, сейчас root, t9cqTCGxJy

### /logs
> логи nginx

### /nginx
> конфиг для nginx wordpress.conf можно вообще не трогать

### /ssl_certs
> в эту директорию автоматический генерируется ключ SSL (let's encrypt)

### /wp-api 
> тема и плагины лежат на github в дериктории wp

### /uploads.ini 
> настройка php 

## На digitalOcean
> создаем дроплет из Marketplace -> Docker 5:19.03.1~3 on 18.04 (берем последнюю версию) plan "Standart" за 5$
> в Networking добавляем домен и подключаем к дроплету CNAME "www" добавляем только в cloudflare
> Заходим по IP дроплета, создаем директорию(можно в корне), не имеет значения где. и копируем проект с вашего локального ПК на дроплет по SSH, далее запускаем проект как описал в самом начале коммандой `docker-compose up -d`

## cloudflare
> добавляем сайт с ip нашего дроплета
> 
> во вкладе DNS добавляем CNAME > Name: `www` Content: <domaine.com>
> 
> Во вкладке SSL/TLS выставляем Full (Encrypts end-to-end, using a self signed certificate on the server)