using Microsoft.EntityFrameworkCore;
using PropertyManagementAPI.Data;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public class TenantService : ITenantService
{
    private readonly PropertyManagementDbContext _context;

    public TenantService(PropertyManagementDbContext context)
    {
        _context = context;
    }

    public async Task<IEnumerable<Tenant>> GetAllTenantsAsync()
    {
        return await _context.Tenants
            .Include(t => t.Property)
            .ToListAsync();
    }

    public async Task<Tenant?> GetTenantByIdAsync(int id)
    {
        return await _context.Tenants
            .Include(t => t.Property)
            .Include(t => t.Payments)
            .Include(t => t.Complaints)
            .FirstOrDefaultAsync(t => t.Id == id);
    }

    public async Task<IEnumerable<Tenant>> GetTenantsByPropertyIdAsync(int propertyId)
    {
        return await _context.Tenants
            .Where(t => t.PropertyId == propertyId)
            .Include(t => t.Property)
            .ToListAsync();
    }

    public async Task<Tenant> CreateTenantAsync(CreateTenantDto tenantDto)
    {
        var tenant = new Tenant
        {
            FirstName = tenantDto.FirstName,
            LastName = tenantDto.LastName,
            Email = tenantDto.Email,
            Phone = tenantDto.Phone,
            PropertyId = tenantDto.PropertyId,
            UnitNumber = tenantDto.UnitNumber,
            LeaseStartDate = tenantDto.LeaseStartDate,
            LeaseEndDate = tenantDto.LeaseEndDate,
            MonthlyRent = tenantDto.MonthlyRent,
            SecurityDeposit = tenantDto.SecurityDeposit,
            Status = "Active",
            CreatedAt = DateTime.UtcNow
        };

        _context.Tenants.Add(tenant);
        await _context.SaveChangesAsync();

        return tenant;
    }

    public async Task<Tenant?> UpdateTenantAsync(int id, UpdateTenantDto tenantDto)
    {
        var tenant = await _context.Tenants.FindAsync(id);
        if (tenant == null)
            return null;

        if (tenantDto.FirstName != null) tenant.FirstName = tenantDto.FirstName;
        if (tenantDto.LastName != null) tenant.LastName = tenantDto.LastName;
        if (tenantDto.Email != null) tenant.Email = tenantDto.Email;
        if (tenantDto.Phone != null) tenant.Phone = tenantDto.Phone;
        if (tenantDto.UnitNumber != null) tenant.UnitNumber = tenantDto.UnitNumber;
        if (tenantDto.LeaseStartDate.HasValue) tenant.LeaseStartDate = tenantDto.LeaseStartDate.Value;
        if (tenantDto.LeaseEndDate.HasValue) tenant.LeaseEndDate = tenantDto.LeaseEndDate.Value;
        if (tenantDto.MonthlyRent.HasValue) tenant.MonthlyRent = tenantDto.MonthlyRent.Value;
        if (tenantDto.SecurityDeposit.HasValue) tenant.SecurityDeposit = tenantDto.SecurityDeposit.Value;
        if (tenantDto.Status != null) tenant.Status = tenantDto.Status;

        tenant.UpdatedAt = DateTime.UtcNow;

        await _context.SaveChangesAsync();
        return tenant;
    }

    public async Task<bool> DeleteTenantAsync(int id)
    {
        var tenant = await _context.Tenants.FindAsync(id);
        if (tenant == null)
            return false;

        _context.Tenants.Remove(tenant);
        await _context.SaveChangesAsync();
        return true;
    }
}
