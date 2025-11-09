using Microsoft.AspNetCore.Mvc;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Services;

namespace PropertyManagementAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
public class MaintenanceRequestsController : ControllerBase
{
    private readonly IMaintenanceService _maintenanceService;
    private readonly ILogger<MaintenanceRequestsController> _logger;

    public MaintenanceRequestsController(IMaintenanceService maintenanceService, ILogger<MaintenanceRequestsController> logger)
    {
        _maintenanceService = maintenanceService;
        _logger = logger;
    }

    [HttpGet]
    public async Task<IActionResult> GetAllMaintenanceRequests()
    {
        try
        {
            var requests = await _maintenanceService.GetAllMaintenanceRequestsAsync();
            return Ok(requests);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving all maintenance requests");
            return StatusCode(500, "An error occurred while retrieving maintenance requests");
        }
    }

    [HttpGet("{id}")]
    public async Task<IActionResult> GetMaintenanceRequestById(int id)
    {
        try
        {
            var request = await _maintenanceService.GetMaintenanceRequestByIdAsync(id);
            if (request == null)
                return NotFound($"Maintenance request with ID {id} not found");

            return Ok(request);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving maintenance request with ID {RequestId}", id);
            return StatusCode(500, "An error occurred while retrieving the maintenance request");
        }
    }

    [HttpGet("property/{propertyId}")]
    public async Task<IActionResult> GetMaintenanceRequestsByPropertyId(int propertyId)
    {
        try
        {
            var requests = await _maintenanceService.GetMaintenanceRequestsByPropertyIdAsync(propertyId);
            return Ok(requests);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving maintenance requests for property {PropertyId}", propertyId);
            return StatusCode(500, "An error occurred while retrieving maintenance requests");
        }
    }

    [HttpPost]
    public async Task<IActionResult> CreateMaintenanceRequest([FromBody] CreateMaintenanceRequestDto requestDto)
    {
        try
        {
            var request = await _maintenanceService.CreateMaintenanceRequestAsync(requestDto);
            return CreatedAtAction(nameof(GetMaintenanceRequestById), new { id = request.Id }, request);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating maintenance request");
            return StatusCode(500, "An error occurred while creating the maintenance request");
        }
    }

    [HttpPut("{id}")]
    public async Task<IActionResult> UpdateMaintenanceRequest(int id, [FromBody] UpdateMaintenanceRequestDto requestDto)
    {
        try
        {
            var request = await _maintenanceService.UpdateMaintenanceRequestAsync(id, requestDto);
            if (request == null)
                return NotFound($"Maintenance request with ID {id} not found");

            return Ok(request);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error updating maintenance request with ID {RequestId}", id);
            return StatusCode(500, "An error occurred while updating the maintenance request");
        }
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> DeleteMaintenanceRequest(int id)
    {
        try
        {
            var result = await _maintenanceService.DeleteMaintenanceRequestAsync(id);
            if (!result)
                return NotFound($"Maintenance request with ID {id} not found");

            return NoContent();
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting maintenance request with ID {RequestId}", id);
            return StatusCode(500, "An error occurred while deleting the maintenance request");
        }
    }
}
