# Architecture

The application follows a layered architecture.

Client
│
Mercure
│
Symfony Application
│
Services
│
Repository Layer
│
PostgreSQL

## Event Flow

1. Price changes
2. ProductPriceUpdatedEvent dispatched
3. Event subscriber publishes update to Mercure
4. Browser receives update