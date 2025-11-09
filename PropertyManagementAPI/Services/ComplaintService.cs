using Microsoft.EntityFrameworkCore;
using PropertyManagementAPI.Data;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Models;

namespace PropertyManagementAPI.Services;

public class ComplaintService : IComplaintService
{
    private readonly PropertyManagementDbContext _context;

    public ComplaintService(PropertyManagementDbContext context)
    {
        _context = context;
    }

    public async Task<IEnumerable<Complaint>> GetAllComplaintsAsync()
    {
        return await _context.Complaints
            .Include(c => c.Tenant)
            .ToListAsync();
    }

    public async Task<Complaint?> GetComplaintByIdAsync(int id)
    {
        return await _context.Complaints
            .Include(c => c.Tenant)
            .FirstOrDefaultAsync(c => c.Id == id);
    }

    public async Task<IEnumerable<Complaint>> GetComplaintsByTenantIdAsync(int tenantId)
    {
        return await _context.Complaints
            .Where(c => c.TenantId == tenantId)
            .Include(c => c.Tenant)
            .ToListAsync();
    }

    public async Task<Complaint> CreateComplaintAsync(CreateComplaintDto complaintDto)
    {
        var complaint = new Complaint
        {
            TenantId = complaintDto.TenantId,
            Subject = complaintDto.Subject,
            Description = complaintDto.Description,
            Category = complaintDto.Category,
            Priority = complaintDto.Priority,
            Status = "Open",
            SubmittedDate = DateTime.UtcNow,
            CreatedAt = DateTime.UtcNow
        };

        _context.Complaints.Add(complaint);
        await _context.SaveChangesAsync();

        return complaint;
    }

    public async Task<Complaint?> UpdateComplaintAsync(int id, UpdateComplaintDto complaintDto)
    {
        var complaint = await _context.Complaints.FindAsync(id);
        if (complaint == null)
            return null;

        if (complaintDto.Status != null)
        {
            complaint.Status = complaintDto.Status;
            if (complaintDto.Status == "Resolved")
                complaint.ResolvedDate = DateTime.UtcNow;
        }
        if (complaintDto.Resolution != null) complaint.Resolution = complaintDto.Resolution;
        if (complaintDto.AssignedTo != null) complaint.AssignedTo = complaintDto.AssignedTo;

        complaint.UpdatedAt = DateTime.UtcNow;

        await _context.SaveChangesAsync();
        return complaint;
    }

    public async Task<bool> DeleteComplaintAsync(int id)
    {
        var complaint = await _context.Complaints.FindAsync(id);
        if (complaint == null)
            return false;

        _context.Complaints.Remove(complaint);
        await _context.SaveChangesAsync();
        return true;
    }
}
