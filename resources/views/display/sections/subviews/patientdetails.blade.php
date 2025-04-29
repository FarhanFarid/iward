<div class="card shadow-sm border @if(isset($bed['patdemo'])) border-success @else border-secondary @endif">
    <div class="card-body p-2">
        <h6 class="card-title mb-1">Bed: {{ $bed['bedno'] ?? 'N/A' }}</h6>
        
        @if(isset($bed['patdemo']))
            <p class="mb-0"><strong>MRN:</strong> {{ $bed['mrn'] ?? '-' }}</p>
            <p class="mb-0"><strong>Doctor:</strong> {{ $bed['patdemo']['epiDoc'] ?? '-' }}</p>
            <p class="mb-0"><strong>LOS:</strong> 2 days</p>
            <p class="mb-0 text-success"><strong>Status:</strong> Occupied</p>
        @else
            <p class="text-muted mb-0">No patient assigned</p>
            <p class="mb-0"><strong>Status:</strong> Unoccupied</p>
        @endif
    </div>
</div>
