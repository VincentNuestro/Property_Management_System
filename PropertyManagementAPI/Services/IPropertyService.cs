using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public interface IPropertyService
{
    Task<IEnumerable<Property>> GetAllPropertiesAsync();
    Task<Property?> GetPropertyByIdAsync(int id);
    Task<Property> CreatePropertyAsync(CreatePropertyDto propertyDto);
    Task<Property?> UpdatePropertyAsync(int id, UpdatePropertyDto propertyDto);
    Task<bool> DeletePropertyAsync(int id);
}
