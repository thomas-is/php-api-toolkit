# PHP skeleton

PHP template with nginx setup.

## TL;TR

Start the server on localhost:8080 using docker:
```bash
./run-dev-docker.sh
```

### API endpoints

```bash
curl -s -X POST -d "some stuff" http://localhost:8080/api/ping | jq .
```
```bash
curl -s http://localhost:8080/api/server | jq .
```
```bash
curl -s \
  -H "Authorization: 0123456789abcdef" \
  http://localhost:8080/api/auth | jq .
```

