using Microsoft.AspNetCore.Mvc;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Services;

namespace PropertyManagementAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
public class ComplaintsController : ControllerBase
{
    private readonly IComplaintService _complaintService;
    private readonly ILogger<ComplaintsController> _logger;

    public ComplaintsController(IComplaintService complaintService, ILogger<ComplaintsController> logger)
    {
        _complaintService = complaintService;
        _logger = logger;
    }

    [HttpGet]
    public async Task<IActionResult> GetAllComplaints()
    {
        try
        {
            var complaints = await _complaintService.GetAllComplaintsAsync();
            return Ok(complaints);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving all complaints");
            return StatusCode(500, "An error occurred while retrieving complaints");
        }
    }

    [HttpGet("{id}")]
    public async Task<IActionResult> GetComplaintById(int id)
    {
        try
        {
            var complaint = await _complaintService.GetComplaintByIdAsync(id);
            if (complaint == null)
                return NotFound($"Complaint with ID {id} not found");

            return Ok(complaint);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving complaint with ID {ComplaintId}", id);
            return StatusCode(500, "An error occurred while retrieving the complaint");
        }
    }

    [HttpGet("tenant/{tenantId}")]
    public async Task<IActionResult> GetComplaintsByTenantId(int tenantId)
    {
        try
        {
            var complaints = await _complaintService.GetComplaintsByTenantIdAsync(tenantId);
            return Ok(complaints);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving complaints for tenant {TenantId}", tenantId);
            return StatusCode(500, "An error occurred while retrieving complaints");
        }
    }

    [HttpPost]
    public async Task<IActionResult> CreateComplaint([FromBody] CreateComplaintDto complaintDto)
    {
        try
        {
            var complaint = await _complaintService.CreateComplaintAsync(complaintDto);
            return CreatedAtAction(nameof(GetComplaintById), new { id = complaint.Id }, complaint);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating complaint");
            return StatusCode(500, "An error occurred while creating the complaint");
        }
    }

    [HttpPut("{id}")]
    public async Task<IActionResult> UpdateComplaint(int id, [FromBody] UpdateComplaintDto complaintDto)
    {
        try
        {
            var complaint = await _complaintService.UpdateComplaintAsync(id, complaintDto);
            if (complaint == null)
                return NotFound($"Complaint with ID {id} not found");

            return Ok(complaint);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error updating complaint with ID {ComplaintId}", id);
            return StatusCode(500, "An error occurred while updating the complaint");
        }
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> DeleteComplaint(int id)
    {
        try
        {
            var result = await _complaintService.DeleteComplaintAsync(id);
            if (!result)
                return NotFound($"Complaint with ID {id} not found");

            return NoContent();
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting complaint with ID {ComplaintId}", id);
            return StatusCode(500, "An error occurred while deleting the complaint");
        }
    }
}
