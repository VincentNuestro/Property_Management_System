using Microsoft.AspNetCore.Mvc;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Services;

namespace PropertyManagementAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
public class TenantsController : ControllerBase
{
    private readonly ITenantService _tenantService;
    private readonly ILogger<TenantsController> _logger;

    public TenantsController(ITenantService tenantService, ILogger<TenantsController> logger)
    {
        _tenantService = tenantService;
        _logger = logger;
    }

    [HttpGet]
    public async Task<IActionResult> GetAllTenants()
    {
        try
        {
            var tenants = await _tenantService.GetAllTenantsAsync();
            return Ok(tenants);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving all tenants");
            return StatusCode(500, "An error occurred while retrieving tenants");
        }
    }

    [HttpGet("{id}")]
    public async Task<IActionResult> GetTenantById(int id)
    {
        try
        {
            var tenant = await _tenantService.GetTenantByIdAsync(id);
            if (tenant == null)
                return NotFound($"Tenant with ID {id} not found");

            return Ok(tenant);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving tenant with ID {TenantId}", id);
            return StatusCode(500, "An error occurred while retrieving the tenant");
        }
    }

    [HttpGet("property/{propertyId}")]
    public async Task<IActionResult> GetTenantsByPropertyId(int propertyId)
    {
        try
        {
            var tenants = await _tenantService.GetTenantsByPropertyIdAsync(propertyId);
            return Ok(tenants);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving tenants for property {PropertyId}", propertyId);
            return StatusCode(500, "An error occurred while retrieving tenants");
        }
    }

    [HttpPost]
    public async Task<IActionResult> CreateTenant([FromBody] CreateTenantDto tenantDto)
    {
        try
        {
            var tenant = await _tenantService.CreateTenantAsync(tenantDto);
            return CreatedAtAction(nameof(GetTenantById), new { id = tenant.Id }, tenant);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating tenant");
            return StatusCode(500, "An error occurred while creating the tenant");
        }
    }

    [HttpPut("{id}")]
    public async Task<IActionResult> UpdateTenant(int id, [FromBody] UpdateTenantDto tenantDto)
    {
        try
        {
            var tenant = await _tenantService.UpdateTenantAsync(id, tenantDto);
            if (tenant == null)
                return NotFound($"Tenant with ID {id} not found");

            return Ok(tenant);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error updating tenant with ID {TenantId}", id);
            return StatusCode(500, "An error occurred while updating the tenant");
        }
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> DeleteTenant(int id)
    {
        try
        {
            var result = await _tenantService.DeleteTenantAsync(id);
            if (!result)
                return NotFound($"Tenant with ID {id} not found");

            return NoContent();
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting tenant with ID {TenantId}", id);
            return StatusCode(500, "An error occurred while deleting the tenant");
        }
    }
}
