# Coordinatio – Core Workflow Specification

> “This workflow specification is a living document and may evolve over time.”

## Overview

This document describes the operational workflow of the Coordinatio system.

The goal is to define how guests, hotel staff, and administrators interact with the system and how service requests move through the platform.

The system operates in real time so that all relevant users receive updates immediately when the state of a request changes.

---

# User Roles

The system contains several user roles.

### Guest

A hotel guest using the provided tablet to request services.

### Reception

Reception staff responsible for check-in, check-out, and assisting guests with requests.

### Service Staff

Employees working in operational departments such as:

- kitchen
- room service
- housekeeping

They receive and process service tasks.

### Administrator

Administrators configure the system and manage employees and services.

---

# Guest Session Workflow

## Check-In

When a guest checks in at the reception:

1. Reception assigns the guest to a room.
2. A guest session is created in the system.
3. The guest receives a tablet and a password.
4. The guest logs into the tablet using the password.

After login the system automatically connects the guest to their room.

The guest can now access the available hotel services.

---

## Guest Access

Once logged in, the guest can:

- browse available services
- place service requests
- schedule services for later
- track the progress of their requests

The guest always sees the current status of their requests.

---

## Check-Out

When the guest checks out:

1. Reception ends the guest session.
2. The tablet access is disabled.
3. The guest can no longer place service requests.

Any unfinished requests are closed or handled by staff.

---

# Employee Workflow

## Employee Registration

Administrators can register hotel employees in the system.

Employee profiles contain:

- name
- department
- role
- login credentials

Departments may include:

- kitchen
- room service
- housekeeping
- reception
- administration

Employees will later be able to log in using their own devices such as tablets or phones.

For the first version, it is assumed that staff devices are already logged in within their department interface.

---

# Service Management

Administrators are responsible for defining the services available in the hotel.

Each service includes the following information:

- service name
- description
- responsible department
- service category
- availability hours
- whether scheduling is allowed

Examples of services:

Food Ordering  
Room Cleaning  
Towel Delivery  
Drink Service  
Laundry Service

Administrators can activate or deactivate services at any time.

---

# Service Request Workflow

## Step 1 – Request Creation

A service request can be created in two ways:

### Guest Request

The guest places a request using the tablet.

### Reception Request

Reception staff enter a request on behalf of the guest.

Examples:

- "Clean my room while I am away"
- "Prepare dinner for when I return at 18:00"
- "Bring extra towels"

---

## Step 2 – Request Routing

Once a request is created:

1. The system determines the responsible department.
2. The request appears in the task list of that department.

Example:

Food order → Kitchen  
Cleaning request → Housekeeping  
Towel request → Room Service

---

## Step 3 – Task Processing

Staff members in the responsible department process the request.

Typical actions include:

- accepting a task
- starting work
- marking work as completed

For example:

Kitchen staff start preparing food.

When the meal is ready, the kitchen marks the request as **ready for delivery**.

---

## Step 4 – Cross-Department Tasks

Some requests involve multiple departments.

Example: Food Order

1. Guest orders food.
2. Kitchen prepares the meal.
3. Kitchen marks the order as ready.
4. Room service receives a delivery task.
5. Room service delivers the meal to the guest.

---

## Step 5 – Completion

Once the service is delivered:

1. Staff mark the request as completed.
2. The guest sees the final status.
3. The request is archived in the system.

---

# Scheduled Services

Some services can be scheduled for a specific time.

Example scenarios:

- cleaning scheduled for 14:00
- dinner scheduled for 19:00
- drinks delivered at 21:30

The system ensures that scheduled requests appear in the department task lists at the correct time.

---

# Real-Time Updates

The system operates in real time.

Whenever an action occurs, the system immediately notifies all relevant users.

Examples of updates:

- new service request created
- request accepted by staff
- preparation started
- task completed
- delivery started

This allows guests, staff, and administrators to always see the latest system state.

---

# Department Interfaces

Each department has its own task interface.

Examples:

Kitchen Interface  
Shows incoming food orders and preparation tasks.

Room Service Interface  
Shows delivery tasks.

Housekeeping Interface  
Shows cleaning tasks.

Reception Interface  
Manages guest sessions and requests.

Administration Interface  
Manages employees, services, and system configuration.

---

# Administration Dashboard

Administrators have access to a central operations dashboard.

The dashboard displays:

- all active service requests
- department workloads
- scheduled requests
- completed services
- system activity timeline

This allows hotel management to monitor operations across the entire hotel.

---

# Future Improvements

The system is designed to support additional features later.

Examples include:

- staff login from personal mobile devices
- permanent tablets in hotel rooms
- guest access through QR codes
- service analytics and reporting
- integration with hotel management systems

---

# Summary

Coordinatio provides a structured workflow that connects guests, staff, and hotel management in one coordinated service system.

Guests can easily request services, staff can efficiently process tasks, and administrators maintain full control and visibility over hotel operations.
