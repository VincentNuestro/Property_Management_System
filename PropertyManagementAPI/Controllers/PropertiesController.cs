using Microsoft.AspNetCore.Mvc;
using PropertyManagementAPI.DTOs;
using PropertyManagementAPI.Services;

namespace PropertyManagementAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
public class PropertiesController : ControllerBase
{
    private readonly IPropertyService _propertyService;
    private readonly ILogger<PropertiesController> _logger;

    public PropertiesController(IPropertyService propertyService, ILogger<PropertiesController> logger)
    {
        _propertyService = propertyService;
        _logger = logger;
    }

    [HttpGet]
    public async Task<IActionResult> GetAllProperties()
    {
        try
        {
            var properties = await _propertyService.GetAllPropertiesAsync();
            return Ok(properties);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving all properties");
            return StatusCode(500, "An error occurred while retrieving properties");
        }
    }

    [HttpGet("{id}")]
    public async Task<IActionResult> GetPropertyById(int id)
    {
        try
        {
            var property = await _propertyService.GetPropertyByIdAsync(id);
            if (property == null)
                return NotFound($"Property with ID {id} not found");

            return Ok(property);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error retrieving property with ID {PropertyId}", id);
            return StatusCode(500, "An error occurred while retrieving the property");
        }
    }

    [HttpPost]
    public async Task<IActionResult> CreateProperty([FromBody] CreatePropertyDto propertyDto)
    {
        try
        {
            var property = await _propertyService.CreatePropertyAsync(propertyDto);
            return CreatedAtAction(nameof(GetPropertyById), new { id = property.Id }, property);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error creating property");
            return StatusCode(500, "An error occurred while creating the property");
        }
    }

    [HttpPut("{id}")]
    public async Task<IActionResult> UpdateProperty(int id, [FromBody] UpdatePropertyDto propertyDto)
    {
        try
        {
            var property = await _propertyService.UpdatePropertyAsync(id, propertyDto);
            if (property == null)
                return NotFound($"Property with ID {id} not found");

            return Ok(property);
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error updating property with ID {PropertyId}", id);
            return StatusCode(500, "An error occurred while updating the property");
        }
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> DeleteProperty(int id)
    {
        try
        {
            var result = await _propertyService.DeletePropertyAsync(id);
            if (!result)
                return NotFound($"Property with ID {id} not found");

            return NoContent();
        }
        catch (Exception ex)
        {
            _logger.LogError(ex, "Error deleting property with ID {PropertyId}", id);
            return StatusCode(500, "An error occurred while deleting the property");
        }
    }
}
