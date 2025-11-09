using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public interface ITenantService
{
    Task<IEnumerable<Tenant>> GetAllTenantsAsync();
    Task<Tenant?> GetTenantByIdAsync(int id);
    Task<IEnumerable<Tenant>> GetTenantsByPropertyIdAsync(int propertyId);
    Task<Tenant> CreateTenantAsync(CreateTenantDto tenantDto);
    Task<Tenant?> UpdateTenantAsync(int id, UpdateTenantDto tenantDto);
    Task<bool> DeleteTenantAsync(int id);
}
