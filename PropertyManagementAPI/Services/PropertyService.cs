using Microsoft.EntityFrameworkCore;
using PropertyManagementAPI.Data;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public class PropertyService : IPropertyService
{
    private readonly PropertyManagementDbContext _context;

    public PropertyService(PropertyManagementDbContext context)
    {
        _context = context;
    }

    public async Task<IEnumerable<Property>> GetAllPropertiesAsync()
    {
        return await _context.Properties
            .Include(p => p.Tenants)
            .ToListAsync();
    }

    public async Task<Property?> GetPropertyByIdAsync(int id)
    {
        return await _context.Properties
            .Include(p => p.Tenants)
            .Include(p => p.MaintenanceRequests)
            .FirstOrDefaultAsync(p => p.Id == id);
    }

    public async Task<Property> CreatePropertyAsync(CreatePropertyDto propertyDto)
    {
        var property = new Property
        {
            Name = propertyDto.Name,
            Address = propertyDto.Address,
            City = propertyDto.City,
            State = propertyDto.State,
            ZipCode = propertyDto.ZipCode,
            PropertyType = propertyDto.PropertyType,
            TotalUnits = propertyDto.TotalUnits,
            MonthlyRent = propertyDto.MonthlyRent,
            Status = "Active",
            CreatedAt = DateTime.UtcNow
        };

        _context.Properties.Add(property);
        await _context.SaveChangesAsync();

        return property;
    }

    public async Task<Property?> UpdatePropertyAsync(int id, UpdatePropertyDto propertyDto)
    {
        var property = await _context.Properties.FindAsync(id);
        if (property == null)
            return null;

        if (propertyDto.Name != null) property.Name = propertyDto.Name;
        if (propertyDto.Address != null) property.Address = propertyDto.Address;
        if (propertyDto.City != null) property.City = propertyDto.City;
        if (propertyDto.State != null) property.State = propertyDto.State;
        if (propertyDto.ZipCode != null) property.ZipCode = propertyDto.ZipCode;
        if (propertyDto.PropertyType != null) property.PropertyType = propertyDto.PropertyType;
        if (propertyDto.TotalUnits.HasValue) property.TotalUnits = propertyDto.TotalUnits.Value;
        if (propertyDto.MonthlyRent.HasValue) property.MonthlyRent = propertyDto.MonthlyRent.Value;
        if (propertyDto.Status != null) property.Status = propertyDto.Status;

        property.UpdatedAt = DateTime.UtcNow;

        await _context.SaveChangesAsync();
        return property;
    }

    public async Task<bool> DeletePropertyAsync(int id)
    {
        var property = await _context.Properties.FindAsync(id);
        if (property == null)
            return false;

        _context.Properties.Remove(property);
        await _context.SaveChangesAsync();
        return true;
    }
}
