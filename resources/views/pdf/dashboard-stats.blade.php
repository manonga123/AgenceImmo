<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques</title>
  <style>
    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 12px;
      color: #333;
      background: #fff;
      padding: 30px;
    }

    /* EN-TÊTE */
    .header {
      border-bottom: 2px solid #c5a055;
      padding-bottom: 12px;
      margin-bottom: 24px;
    }
    .header h1 {
      font-size: 20px;
      color: #111;
      margin-bottom: 4px;
    }
    .header p {
      font-size: 10px;
      color: #888;
    }
    .meta {
      float: right;
      text-align: right;
      font-size: 10px;
      color: #888;
    }

    /* TITRE DE SECTION */
    h2 {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #c5a055;
      border-bottom: 1px solid #e8e2d6;
      padding-bottom: 6px;
      margin: 24px 0 12px;
    }

    /* TABLEAU */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 8px;
    }
    th {
      background: #f5f5f5;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #555;
      padding: 8px 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    td {
      padding: 8px 10px;
      font-size: 11px;
      color: #333;
      border-bottom: 1px solid #eee;
    }
    tr:last-child td { border-bottom: none; }
    .total td { font-weight: 700; background: #fafafa; }

    /* BADGE STATUT */
    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 9px;
      font-weight: 700;
    }
    .badge-dispo { background: #e8f0ff; color: #2255cc; }
    .badge-vendu { background: #fff5d6; color: #8a6000; }
    .badge-loue  { background: #e6f7ee; color: #1a6e3c; }

    /* BARRE DE PROGRESSION */
    .bar-bg {
      background: #eee;
      border-radius: 3px;
      height: 7px;
      width: 100%;
    }
    .bar-fill {
      background: #c5a055;
      border-radius: 3px;
      height: 7px;
    }

    /* FOOTER */
    .footer {
      margin-top: 32px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
      font-size: 9px;
      color: #aaa;
    }
  </style>
</head>
<body>

  {{-- EN-TÊTE --}}
  <div class="header">
    <div class="meta">
      {{ $user->name }}<br>
      {{ $generatedAt }}
    </div>
    <h1>Rapport statistiques</h1>
    <p>Système de gestion immobilière</p>
  </div>

  {{-- 1. UTILISATEURS --}}
  <h2>Utilisateurs</h2>
  <table>
    <thead>
      <tr>
        <th>Catégorie</th>
        <th>Nombre</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Clients</td><td>{{ $totalUsers }}</td></tr>
      <tr><td>Propriétaires</td><td>{{ $totalOwners }}</td></tr>
      <tr><td>Rendez-vous total</td><td>{{ $stats['totalAppointments'] ?? 0 }}</td></tr>
      <tr class="total"><td>Total utilisateurs</td><td>{{ $totalAllUsers }}</td></tr>
    </tbody>
  </table>

  {{-- 2. PROPRIÉTÉS --}}
  <h2>Propriétés</h2>
  @php
    $total    = max($stats['totalProperties'] ?? 1, 1);
    $totalVal = $stats['totalValue'] ?? 0;
    $dispo    = $stats['availableProperties'] ?? 0;
    $vendu    = $stats['soldProperties'] ?? 0;
    $loue     = $stats['rentedProperties'] ?? 0;
  @endphp
  <table>
    <thead>
      <tr>
        <th>Statut</th>
        <th>Nombre</th>
        <th>%</th>
        <th>Valeur (Ar)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="badge badge-dispo">Disponibles</span></td>
        <td>{{ $dispo }}</td>
        <td>{{ number_format(($dispo/$total)*100, 1) }}%</td>
        <td>{{ number_format($dispoVal, 0, ',', ' ') }}</td>
      </tr>
      <tr>
        <td><span class="badge badge-vendu">Vendues</span></td>
        <td>{{ $vendu }}</td>
        <td>{{ number_format(($vendu/$total)*100, 1) }}%</td>
        <td>{{ number_format($venduVal, 0, ',', ' ') }}</td>
      </tr>
      <tr>
        <td><span class="badge badge-loue">Louées</span></td>
        <td>{{ $loue }}</td>
        <td>{{ number_format(($loue/$total)*100, 1) }}%</td>
        <td>{{ number_format($loueVal, 0, ',', ' ') }}</td>
      </tr>
      <tr class="total">
        <td>Total</td>
        <td>{{ $stats['totalProperties'] ?? 0 }}</td>
        <td>100%</td>
        <td>{{ number_format($totalVal, 0, ',', ' ') }}</td>
      </tr>
    </tbody>
  </table>

  {{-- 3. REVENUS MENSUELS --}}
  <h2>Historique de revenus — {{ now()->year }}</h2>
  @php
    $mois     = ['Janvier','Février','Mars','Avril','Mai','Juin',
                 'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    $maxRev   = max(array_merge($monthlyRevenue, [1]));
    $totalRev = array_sum($monthlyRevenue);
  @endphp
  <table>
    <thead>
      <tr>
        <th style="width:25%;">Mois</th>
        <th style="width:30%;">Revenus (Ar)</th>
        <th>Progression</th>
      </tr>
    </thead>
    <tbody>
      @foreach($mois as $i => $nom)
      @php
        $rev = $monthlyRevenue[$i] ?? 0;
        $pct = $maxRev > 0 ? round(($rev / $maxRev) * 100) : 0;
      @endphp
      <tr>
        <td>{{ $nom }}</td>
        <td>{{ number_format($rev, 0, ',', ' ') }}</td>
        <td>
          <div class="bar-bg">
            <div class="bar-fill" style="width:{{ $pct }}%;"></div>
          </div>
        </td>
      </tr>
      @endforeach
      <tr class="total">
        <td>Total annuel</td>
        <td>{{ number_format($totalRev, 0, ',', ' ') }}</td>
        <td></td>
      </tr>
    </tbody>
  </table>

  {{-- FOOTER --}}
  <div class="footer">
    Généré le {{ $generatedAt }} &middot; Document confidentiel
  </div>

</body>
</html>