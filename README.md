## Rodando o Projeto Via Docker

### Requisitos do Sistema

*   Docker
*   Docker-compose

### Passo a Passo

1. Clonar o projeto

2. Dar permissão na storage:

```
sudo chmod -R 777 storage
```

3. Copiar env.example para .env:

```
   cp .env.example .env
```

4. Buildar a docker:

```
docker-compose up -d
```

5. Rodar os comandos de configuração para a docker:

```
docker exec -it app-shipping composer start-app
```

6. Acessar no navegador:

```
http://localhost/8005
```


By - Matheus Tripolone