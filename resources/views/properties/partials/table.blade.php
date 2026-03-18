@if($appointments->isEmpty())
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    {{ $emptyMessage ?? 'Vous n\'avez aucune demande pour le moment.' }}
</div>
@else
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Type</th>
                <th>Propriété</th>
                <th>Date/Heure</th>
                <th>Statut</th>
                <th>Action</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            @include('appointments.partials.row', ['appointment' => $appointment])
            @endforeach
        </tbody>
    </table>
</div>

{{ $appointments->links() }}
@endif