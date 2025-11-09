# Property Management API

A comprehensive RESTful API built with ASP.NET Core 8.0 for managing properties, tenants, maintenance requests, and complaints.

## Features

- **Property Management**: Create, read, update, and delete properties
- **Tenant Management**: Manage tenant information and leases
- **Maintenance Requests**: Track maintenance requests and work orders
- **Complaints**: Handle tenant complaints and resolutions
- **RESTful API**: Clean, consistent API endpoints
- **Entity Framework Core**: Database management with EF Core
- **Swagger/OpenAPI**: Interactive API documentation

## Prerequisites

- [.NET 8.0 SDK](https://dotnet.microsoft.com/download/dotnet/8.0)
- SQL Server (LocalDB, Express, or full version)
- Visual Studio 2022 or Visual Studio Code (optional)

## Getting Started

### 1. Clone the Repository

```bash
cd PropertyManagementAPI
```

### 2. Update Database Connection String

Edit `appsettings.json` and update the connection string to match your SQL Server configuration:

```json
{
  "ConnectionStrings": {
    "DefaultConnection": "Server=localhost;Database=PropertyManagementDB;Trusted_Connection=True;TrustServerCertificate=True;"
  }
}
```

For SQL Server authentication, use:
```json
{
  "ConnectionStrings": {
    "DefaultConnection": "Server=localhost;Database=PropertyManagementDB;User Id=your_username;Password=your_password;TrustServerCertificate=True;"
  }
}
```

### 3. Install Dependencies

```bash
dotnet restore
```

### 4. Create Database Migrations

```bash
dotnet ef migrations add InitialCreate
dotnet ef database update
```

### 5. Run the Application

```bash
dotnet run
```

The API will be available at:
- HTTPS: `https://localhost:5001`
- HTTP: `http://localhost:5000`
- Swagger UI: `https://localhost:5001/swagger`

## API Endpoints

### Properties

- `GET /api/properties` - Get all properties
- `GET /api/properties/{id}` - Get property by ID
- `POST /api/properties` - Create a new property
- `PUT /api/properties/{id}` - Update a property
- `DELETE /api/properties/{id}` - Delete a property

### Tenants

- `GET /api/tenants` - Get all tenants
- `GET /api/tenants/{id}` - Get tenant by ID
- `GET /api/tenants/property/{propertyId}` - Get tenants by property
- `POST /api/tenants` - Create a new tenant
- `PUT /api/tenants/{id}` - Update a tenant
- `DELETE /api/tenants/{id}` - Delete a tenant

### Maintenance Requests

- `GET /api/maintenancerequests` - Get all maintenance requests
- `GET /api/maintenancerequests/{id}` - Get maintenance request by ID
- `GET /api/maintenancerequests/property/{propertyId}` - Get requests by property
- `POST /api/maintenancerequests` - Create a new maintenance request
- `PUT /api/maintenancerequests/{id}` - Update a maintenance request
- `DELETE /api/maintenancerequests/{id}` - Delete a maintenance request

### Complaints

- `GET /api/complaints` - Get all complaints
- `GET /api/complaints/{id}` - Get complaint by ID
- `GET /api/complaints/tenant/{tenantId}` - Get complaints by tenant
- `POST /api/complaints` - Create a new complaint
- `PUT /api/complaints/{id}` - Update a complaint
- `DELETE /api/complaints/{id}` - Delete a complaint

## Project Structure

```
PropertyManagementAPI/
├── Controllers/         # API Controllers
│   ├── PropertiesController.cs
│   ├── TenantsController.cs
│   ├── MaintenanceRequestsController.cs
│   └── ComplaintsController.cs
├── Data/               # Database Context
│   └── PropertyManagementDbContext.cs
├── DTOs/               # Data Transfer Objects
│   ├── PropertyDto.cs
│   ├── TenantDto.cs
│   ├── MaintenanceRequestDto.cs
│   └── ComplaintDto.cs
├── Models/             # Entity Models
│   ├── Property.cs
│   ├── Tenant.cs
│   ├── Payment.cs
│   ├── MaintenanceRequest.cs
│   └── Complaint.cs
├── Services/           # Business Logic
│   ├── IPropertyService.cs
│   ├── PropertyService.cs
│   ├── ITenantService.cs
│   ├── TenantService.cs
│   ├── IMaintenanceService.cs
│   ├── MaintenanceService.cs
│   ├── IComplaintService.cs
│   └── ComplaintService.cs
├── Program.cs          # Application entry point
├── appsettings.json    # Configuration
└── PropertyManagementAPI.csproj
```

## Example API Calls

### Create a Property

```bash
POST /api/properties
Content-Type: application/json

{
  "name": "Sunset Apartments",
  "address": "123 Main Street",
  "city": "Los Angeles",
  "state": "CA",
  "zipCode": "90001",
  "propertyType": "Apartment",
  "totalUnits": 50,
  "monthlyRent": 2500.00
}
```

### Create a Tenant

```bash
POST /api/tenants
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "email": "john.doe@example.com",
  "phone": "555-0123",
  "propertyId": 1,
  "unitNumber": "101",
  "leaseStartDate": "2024-01-01",
  "leaseEndDate": "2024-12-31",
  "monthlyRent": 2500.00,
  "securityDeposit": 2500.00
}
```

## Development

### Install Entity Framework Tools

```bash
dotnet tool install --global dotnet-ef
```

### Add a New Migration

```bash
dotnet ef migrations add MigrationName
```

### Update Database

```bash
dotnet ef database update
```

### Remove Last Migration

```bash
dotnet ef migrations remove
```

## Testing

Use Swagger UI at `https://localhost:5001/swagger` to test the API endpoints interactively.

Alternatively, use tools like:
- Postman
- cURL
- REST Client (VS Code extension)

## Configuration

### CORS

The API is configured to allow all origins in development. For production, update the CORS policy in `Program.cs`:

```csharp
builder.Services.AddCors(options =>
{
    options.AddPolicy("AllowSpecificOrigin", policy =>
    {
        policy.WithOrigins("https://yourdomain.com")
              .AllowAnyMethod()
              .AllowAnyHeader();
    });
});
```

### JWT Authentication

The project includes JWT configuration placeholders in `appsettings.json`. To implement authentication:

1. Update the JWT configuration with secure values
2. Implement authentication services
3. Add `[Authorize]` attributes to controllers

## Database Schema

The API manages the following entities:

- **Properties**: Real estate properties
- **Tenants**: Property tenants with lease information
- **Payments**: Tenant payment records
- **MaintenanceRequests**: Maintenance and repair requests
- **Complaints**: Tenant complaints and resolutions

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License.

## Support

For issues and questions, please open an issue in the GitHub repository.
