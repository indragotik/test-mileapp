# MileApp - Fullstack Task Management Application

A modern fullstack monorepo application built with Laravel 11 (Mock API) and Vue 3 (Frontend) for task management with authentication, CRUD operations, filtering, sorting, and pagination.

## 🎯 Overview

MileApp is a task management application that demonstrates:
- **Mock Authentication**: Token-based authentication flow using a hardcoded JWT token
- **Task CRUD**: Complete Create, Read, Update, Delete operations for tasks
- **Advanced Features**: Filtering by status, sorting by priority/title, pagination
- **Modern Stack**: Laravel 11 backend with Vue 3 frontend using Vite
- **Database Optimization**: MongoDB indexes for performance
- **Deployment Ready**: Configured for Vercel deployment

### Demo Credentials
- **Email**: `user@example.com`
- **Password**: `password`

## 🏗️ Project Structure

```
mileapp/
├── apps/
│   ├── api/           # Laravel 11 backend (Mock API)
│   └── web/           # Vue 3 frontend (Vite + Pinia)
├── db/
│   └── indexes.js     # MongoDB index creation script
├── README.md
├── vercel.json        # Deployment configuration
└── env.example        # Environment variables template
```

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 18+
- MongoDB (optional for production)

### Backend Setup (Laravel API)

1. **Navigate to API directory**
   ```bash
   cd apps/api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Start development server**
   ```bash
   php artisan serve
   ```
   API will be available at `http://localhost:8000`

### Frontend Setup (Vue.js)

1. **Navigate to web directory**
   ```bash
   cd apps/web
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Start development server**
   ```bash
   npm run dev
   ```
   Frontend will be available at `http://localhost:3000`

## 📡 API Documentation

### Authentication

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "token": "mocked.jwt.token.123",
  "user": {
    "name": "Demo User",
    "email": "user@example.com"
  }
}
```

### Tasks (Protected Routes)

All task endpoints require the `Authorization: Bearer mocked.jwt.token.123` header.

#### Get Tasks
```http
GET /api/tasks?page=1&perPage=5&status=open&sort=-priority
Authorization: Bearer mocked.jwt.token.123
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Learn Vue",
      "status": "open",
      "priority": 2
    }
  ],
  "meta": {
    "total": 3,
    "page": 1,
    "perPage": 5
  }
}
```

#### Create Task
```http
POST /api/tasks
Authorization: Bearer mocked.jwt.token.123
Content-Type: application/json

{
  "title": "New Task",
  "status": "open",
  "priority": 1
}
```

#### Update Task
```http
PUT /api/tasks/{id}
Authorization: Bearer mocked.jwt.token.123
Content-Type: application/json

{
  "title": "Updated Task",
  "status": "in_progress",
  "priority": 2
}
```

#### Delete Task
```http
DELETE /api/tasks/{id}
Authorization: Bearer mocked.jwt.token.123
```

### Query Parameters

- `page`: Page number (default: 1)
- `perPage`: Items per page (default: 5)
- `status`: Filter by status (`open`, `in_progress`, `done`)
- `sort`: Sort field with optional `-` prefix for descending (`title`, `-title`, `priority`, `-priority`)

## 🎨 Frontend Features

### Authentication Flow
- **Login Page**: Clean, responsive login form with demo credentials
- **Protected Routes**: Automatic redirect to login for unauthenticated users
- **Token Management**: Automatic token storage and API header injection
- **Logout**: Clear authentication state and redirect to login

### Task Management
- **Task List**: Responsive table with status badges and priority indicators
- **Filtering**: Filter tasks by status (All, Open, In Progress, Done)
- **Sorting**: Sort by title (A-Z, Z-A) or priority (High-Low, Low-High)
- **Pagination**: Navigate through pages with customizable items per page
- **CRUD Operations**: Create, edit, and delete tasks with modal forms
- **Real-time Updates**: Immediate UI updates after operations

### Technology Stack
- **Vue 3**: Composition API with reactive state management
- **Pinia**: Modern state management for Vue
- **Vue Router**: Client-side routing with navigation guards
- **Axios**: HTTP client with request/response interceptors
- **Tailwind CSS**: Utility-first CSS framework for styling
- **Vite**: Fast build tool and development server

## 🗄️ Database Optimization

### MongoDB Indexes

The `db/indexes.js` script creates optimized indexes for performance:

```bash
cd db
npm install
npm run create-indexes
```

**Indexes Created:**
- `status`: Optimizes filtering by task status
- `priority`: Optimizes sorting by priority (descending for high priority first)
- `title (text)`: Enables full-text search on task titles
- `status + priority`: Compound index for combined queries
- `created_at`: Optimizes sorting by creation date

**Why These Indexes:**
- **Status Filter**: Most common query pattern - users filter by task status
- **Priority Sort**: Critical for task prioritization and sorting performance
- **Text Search**: Enables fast title-based search functionality
- **Compound Index**: Optimizes complex queries combining status filter + priority sort
- **Timestamp Index**: Future-proofing for date-based sorting and archiving

## 🚀 Deployment

### Vercel Deployment

1. **Install Vercel CLI**
   ```bash
   npm i -g vercel
   ```

2. **Deploy from project root**
   ```bash
   vercel
   ```

3. **Configure environment variables**
   - Set `VITE_API_BASE_URL` to your deployed API URL
   - Set `MONGO_URI` for MongoDB connection (if using)

### Environment Variables

**Backend (Laravel API):**
- `APP_KEY`: Laravel application key
- `APP_ENV`: Environment (production)
- `DB_CONNECTION`: Database connection (mongodb)
- `MONGO_URI`: MongoDB connection string

**Frontend (Vue.js):**
- `VITE_API_BASE_URL`: Backend API URL

### Deployment URLs
- **API**: `https://mileapp-api.vercel.app`
- **Frontend**: `https://mileapp-web.vercel.app`

## 🧪 Testing

### Backend Tests
```bash
cd apps/api
php artisan test
```

**Test Coverage:**
- ✅ Unauthorized access returns 401
- ✅ Authenticated user can access tasks
- ✅ Task CRUD operations work correctly
- ✅ Validation errors are handled properly
- ✅ Pagination and filtering work as expected

## 🔧 Development

### Running Tests
```bash
# Backend tests
cd apps/api && php artisan test

# Frontend tests (if added)
cd apps/web && npm run test
```

### Code Quality
- **Laravel**: Follows PSR-12 coding standards
- **Vue.js**: Uses Composition API and modern JavaScript features
- **ESLint**: Configured for Vue 3 and modern JavaScript
- **Prettier**: Code formatting for consistency

## 📝 Design Decisions

### Mock Authentication
- **Why**: Simplifies development and deployment without complex auth setup
- **Implementation**: Hardcoded JWT token with middleware validation
- **Security**: Not for production use - demonstrates auth flow patterns

### MongoDB Integration
- **Why**: Document-based storage fits task management data structure
- **Indexes**: Optimized for common query patterns (filtering, sorting)
- **Performance**: Compound indexes for complex queries

### Monorepo Structure
- **Why**: Keeps related frontend/backend code together
- **Benefits**: Shared configuration, easier deployment, better organization
- **Deployment**: Separate Vercel projects for frontend and backend

### Vue 3 + Pinia
- **Why**: Modern, performant frontend stack
- **Benefits**: Composition API, better TypeScript support, simpler state management
- **Developer Experience**: Hot reload, modern tooling, excellent ecosystem

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🎉 Features Completed

- ✅ Mock API with login and CRUD endpoints
- ✅ Mock auth flow using token-based authentication
- ✅ Task CRUD with filter, sort, pagination, and metadata
- ✅ MongoDB index script
- ✅ Deployment-ready (Vercel configuration)
- ✅ Comprehensive README with design decisions
- ✅ Responsive Vue 3 frontend with modern UI
- ✅ Unit tests for API endpoints
- ✅ Environment configuration for production

---

**Built with ❤️ using Laravel 11, Vue 3, and modern web technologies.**
