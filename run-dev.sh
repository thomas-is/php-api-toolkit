#!/bin/sh

docker run --rm -it \
  --name dev \
  -p 8080:80 \
  -v $(pwd)/ng-default.conf:/etc/nginx/http.d/default.conf \
  -v $(pwd)/srv:/srv \
  0lfi/ng-php8 "$@"
