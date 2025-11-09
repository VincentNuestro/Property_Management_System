namespace PropertyManagementAPI.DTOs;

public class ComplaintDto
{
    public int Id { get; set; }
    public int TenantId { get; set; }
    public string Subject { get; set; } = string.Empty;
    public string Description { get; set; } = string.Empty;
    public string Category { get; set; } = string.Empty;
    public string Priority { get; set; } = string.Empty;
    public string Status { get; set; } = string.Empty;
    public DateTime SubmittedDate { get; set; }
    public DateTime? ResolvedDate { get; set; }
    public string? Resolution { get; set; }
}

public class CreateComplaintDto
{
    public int TenantId { get; set; }
    public string Subject { get; set; } = string.Empty;
    public string Description { get; set; } = string.Empty;
    public string Category { get; set; } = string.Empty;
    public string Priority { get; set; } = "Medium";
}

public class UpdateComplaintDto
{
    public string? Status { get; set; }
    public string? Resolution { get; set; }
    public string? AssignedTo { get; set; }
}
