using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public interface IComplaintService
{
    Task<IEnumerable<Complaint>> GetAllComplaintsAsync();
    Task<Complaint?> GetComplaintByIdAsync(int id);
    Task<IEnumerable<Complaint>> GetComplaintsByTenantIdAsync(int tenantId);
    Task<Complaint> CreateComplaintAsync(CreateComplaintDto complaintDto);
    Task<Complaint?> UpdateComplaintAsync(int id, UpdateComplaintDto complaintDto);
    Task<bool> DeleteComplaintAsync(int id);
}
