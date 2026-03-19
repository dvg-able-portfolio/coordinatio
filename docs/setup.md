# Setup

## 1️⃣ Start Docker Containers

```bash
docker compose up -d
```

## 2️⃣ Initialize the Symfony App

```
./init.sh
```

## 3️⃣ Access the App

[app](http://localhost)


## 4️⃣ Create Entries

In that order

1. Department
2. Employee
3. Service
4. Guest

This project is in an early development stage. Core functionality is present, but important validations (such as preventing the creation of an Employee without a Department) are not yet implemented.
