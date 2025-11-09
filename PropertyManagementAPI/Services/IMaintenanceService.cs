using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public interface IMaintenanceService
{
    Task<IEnumerable<MaintenanceRequest>> GetAllMaintenanceRequestsAsync();
    Task<MaintenanceRequest?> GetMaintenanceRequestByIdAsync(int id);
    Task<IEnumerable<MaintenanceRequest>> GetMaintenanceRequestsByPropertyIdAsync(int propertyId);
    Task<MaintenanceRequest> CreateMaintenanceRequestAsync(CreateMaintenanceRequestDto requestDto);
    Task<MaintenanceRequest?> UpdateMaintenanceRequestAsync(int id, UpdateMaintenanceRequestDto requestDto);
    Task<bool> DeleteMaintenanceRequestAsync(int id);
}
