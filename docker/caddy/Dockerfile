FROM caddy:2.11.2-builder AS builder

RUN xcaddy build \
  --with github.com/dunglas/mercure/caddy

FROM caddy:latest

COPY --from=builder /usr/bin/caddy /usr/bin/caddy

