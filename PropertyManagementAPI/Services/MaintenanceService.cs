using Microsoft.EntityFrameworkCore;
using PropertyManagementAPI.Data;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public class MaintenanceService : IMaintenanceService
{
    private readonly PropertyManagementDbContext _context;

    public MaintenanceService(PropertyManagementDbContext context)
    {
        _context = context;
    }

    public async Task<IEnumerable<MaintenanceRequest>> GetAllMaintenanceRequestsAsync()
    {
        return await _context.MaintenanceRequests
            .Include(m => m.Property)
            .Include(m => m.Tenant)
            .ToListAsync();
    }

    public async Task<MaintenanceRequest?> GetMaintenanceRequestByIdAsync(int id)
    {
        return await _context.MaintenanceRequests
            .Include(m => m.Property)
            .Include(m => m.Tenant)
            .FirstOrDefaultAsync(m => m.Id == id);
    }

    public async Task<IEnumerable<MaintenanceRequest>> GetMaintenanceRequestsByPropertyIdAsync(int propertyId)
    {
        return await _context.MaintenanceRequests
            .Where(m => m.PropertyId == propertyId)
            .Include(m => m.Property)
            .Include(m => m.Tenant)
            .ToListAsync();
    }

    public async Task<MaintenanceRequest> CreateMaintenanceRequestAsync(CreateMaintenanceRequestDto requestDto)
    {
        var maintenanceRequest = new MaintenanceRequest
        {
            PropertyId = requestDto.PropertyId,
            TenantId = requestDto.TenantId,
            Title = requestDto.Title,
            Description = requestDto.Description,
            Category = requestDto.Category,
            Priority = requestDto.Priority,
            Status = "Open",
            RequestedDate = DateTime.UtcNow,
            CreatedAt = DateTime.UtcNow
        };

        _context.MaintenanceRequests.Add(maintenanceRequest);
        await _context.SaveChangesAsync();

        return maintenanceRequest;
    }

    public async Task<MaintenanceRequest?> UpdateMaintenanceRequestAsync(int id, UpdateMaintenanceRequestDto requestDto)
    {
        var request = await _context.MaintenanceRequests.FindAsync(id);
        if (request == null)
            return null;

        if (requestDto.Title != null) request.Title = requestDto.Title;
        if (requestDto.Description != null) request.Description = requestDto.Description;
        if (requestDto.Category != null) request.Category = requestDto.Category;
        if (requestDto.Priority != null) request.Priority = requestDto.Priority;
        if (requestDto.Status != null) request.Status = requestDto.Status;
        if (requestDto.ScheduledDate.HasValue) request.ScheduledDate = requestDto.ScheduledDate.Value;
        if (requestDto.CompletedDate.HasValue) request.CompletedDate = requestDto.CompletedDate.Value;
        if (requestDto.AssignedTo != null) request.AssignedTo = requestDto.AssignedTo;
        if (requestDto.EstimatedCost.HasValue) request.EstimatedCost = requestDto.EstimatedCost.Value;
        if (requestDto.ActualCost.HasValue) request.ActualCost = requestDto.ActualCost.Value;

        request.UpdatedAt = DateTime.UtcNow;

        await _context.SaveChangesAsync();
        return request;
    }

    public async Task<bool> DeleteMaintenanceRequestAsync(int id)
    {
        var request = await _context.MaintenanceRequests.FindAsync(id);
        if (request == null)
            return false;

        _context.MaintenanceRequests.Remove(request);
        await _context.SaveChangesAsync();
        return true;
    }
}
