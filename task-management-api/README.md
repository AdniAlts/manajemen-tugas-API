# Task Management API

## Overview
RESTful API untuk manajemen tugas pribadi dibangun dengan Laravel & PostgreSQL.

## Tech Stack
- Laravel (v12)
- PostgreSQL
- Laravel Sanctum

## Prerequisites
- PHP >= 8.2
- Composer
- PostgreSQL

## Installation
1. Clone repository
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. Setup database credentials di `.env`
6. `php artisan migrate`

## Environment Variables
Tabel berikut berisi environment variables utama yang perlu disesuaikan pada file `.env`:

| Variable | Description | Default / Example |
|----------|-------------|-------------------|
| `APP_NAME` | Nama aplikasi | TaskManagementAPI |
| `APP_ENV` | Environment berjalan | local |
| `APP_KEY` | Kunci enkripsi aplikasi | - |
| `APP_DEBUG` | Mode debug (true/false) | true |
| `APP_URL` | Base URL aplikasi | http://localhost |
| `DB_CONNECTION` | Driver database relasional | pgsql |
| `DB_HOST` | Host database server | 127.0.0.1 |
| `DB_PORT` | Port database server | 5432 |
| `DB_DATABASE` | Nama database | task_management |
| `DB_USERNAME` | Username database | postgres |
| `DB_PASSWORD` | Password database | password |
| `CACHE_STORE` | Session / Cache driver | database |

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tasks` | Get semua task milik user (paginated) |
| POST | `/api/tasks` | Buat task baru |
| GET | `/api/tasks/{id}` | Get detail task berdasarkan UUID |
| PUT | `/api/tasks/{id}` | Update task berdasarkan UUID |
| DELETE | `/api/tasks/{id}` | Hapus (soft-delete) task |

---

## Status & Priority Values
- **Status**: `pending` | `in_progress` | `completed`
- **Priority**: `low` | `medium` | `high`

---

## Request & Response Examples
> ⭐ **Penting**: Semua request di atas membutuhkan Header `Authorization: Bearer {token}` & `Accept: application/json`.

### 1. POST `/api/tasks`
Membuat tugas baru.
**Request:**
```json
{
  "title": "Belajar Laravel",
  "description": "Pelajari konsep dasar Laravel API",
  "priority": "high",
  "due_date": "2026-12-31"
}
```
**Response (201 Created):**
```json
{
  "success": true,
  "message": "Task created successfully",
  "data": {
    "id": "18f9bd2a-abcd-4xyz-1234-56789oklhjkl",
    "title": "Belajar Laravel",
    "description": "Pelajari konsep dasar Laravel API",
    "status": "pending",
    "priority": "high",
    "due_date": "2026-12-31T00:00:00.000000Z",
    "completed_at": null,
    "is_overdue": false,
    "created_at": "2026-03-01T10:50:00.000000Z",
    "updated_at": "2026-03-01T10:50:00.000000Z"
  },
  "errors": null
}
```

### 2. GET `/api/tasks`
Mengambil semua tugas pengguna dengan penomoran halaman otomatis.
**Response (200 OK):**
```json
{
  "success": true,
  "message": "Tasks retrieved successfully",
  "data": [
    {
      "id": "18f9bd2a-abcd-4xyz-1234-56789oklhjkl",
      "title": "Belajar Laravel",
      "...": "..."
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 10,
    "total": 1,
    "last_page": 1
  }
}
```

### 3. GET `/api/tasks/{id}`
Menampilkan detail tugas spesifik.
**Response (200 OK):**
```json
{
  "success": true,
  "message": "Task retrieved successfully",
  "data": {
    "id": "18f9bd2a-abcd-4xyz-1234-56789oklhjkl",
    "title": "Belajar Laravel",
    "...": "..."
  },
  "errors": null
}
```

**Response (404 Not Found):**
```json
{
  "success": false,
  "message": "Task tidak ditemukan",
  "data": null,
  "errors": null
}
```

### 4. PUT `/api/tasks/{id}`
Mengupdate informasi dari sebuah task. Update besifat parsial, tidak wajib semua field diisi kecuali ingin diubah.  
*Tip: Mengubah status ke `"completed"` akan secara otomatis membangkitkan `"completed_at": datetime_sekarang.*

**Request:**
```json
{
  "status": "completed"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Task updated successfully",
  "data": {
    "id": "18f9bd2a-abcd-4xyz-1234-56789oklhjkl",
    "title": "Belajar Laravel",
    "status": "completed",
    "completed_at": "2026-03-01T10:55:00.000000Z",
    "...": "..."
  },
  "errors": null
}
```

### 5. DELETE `/api/tasks/{id}`
Menghapus tugas (soft deletes akan terjadi di database namun tak akan muncul lagi pada response REST API).
**Response (200 OK):**
```json
{
  "success": true,
  "message": "Task deleted successfully",
  "data": null,
  "errors": null
}
```

### Example 422 Validation Error
**Response (422 Unprocessable Entity):**
```json
{
  "success": false,
  "message": "Validation failed",
  "data": null,
  "errors": {
    "priority": [
      "Prioritas tidak valid (low, medium, high)."
    ]
  }
}
```
