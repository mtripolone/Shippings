## Rodando o Projeto Via Docker

### Requisitos do Sistema

*   Docker
*   Docker-compose

### Passo a Passo

1. Clonar o projeto e acessar a pasta do mesmo

```
git clone git@github.com:mtripolone/Shippings.git && cd Shippings
```

2. Dar permissão na storage:

```
sudo chmod -R 777 storage
```

3. Copiar env.example para .env:

```
   cp .env.example .env
```

4. Setar o USER e UID de seu usuário dentro do .env, para pegar os campos rode:
* OBS: apenas para sistemas Linux e Mac OS

```
   echo $USER
```
```
   echo $UID
```

5. Buildar a docker:

```
docker-compose up -d
```

6. Rodar os comandos de configuração para a docker:

```
docker exec -it app-shipping composer start-app
```

7. Acessar no navegador:

```
http://localhost/8005
```


By - Matheus Tripolone
