@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        {{-- {{ dd($stagiairesParEtablissement) }} --}}
        <!-- Statistics cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card" style="border: 2px solid #007BFF;">
                    <div class="card-header" style="font-weight: bold;">Total des Demandes</div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $totalDemandes }}</h3>
                        <i class="ti ti-files" style="font-size: 26px; color: #007BFF;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border: 2px solid #28A745;">
                    <div class="card-header" style="font-weight: bold;">Demandes Approuvées</div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $approvedDemandes }}</h3>
                        <i class="ti ti-circle-check" style="font-size: 26px; color: #28A745;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border: 2px solid #DC3545;">
                    <div class="card-header" style="font-weight: bold;">Demandes Refusées</div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $refusedDemandes }}</h3>
                        <i class="ti ti-trash" style="font-size: 26px; color: #DC3545;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border: 2px solid #FFC107;">
                    <div class="card-header" style="font-weight: bold;">Demandes en attente</div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $pendingDemandes }}</h3>
                        <i class="ti ti-clock-pause" style="font-size: 26px; color: #FFC107;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card" style="border: 2px solid #2b50b8; height: 450px;">
                    <div class="card-header" style="font-weight: bold;">Demandes par Etablissement</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="etablissementChart" style="max-width: 70%; max-height: 90%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="border: 2px solid #40d1e4; height: 450px;">
                    <div class="card-header" style="font-weight: bold;">Status des Demandes</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="statusChart" style="max-width: 100%; max-height: 90%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card" style="border: 2px solid #007BFF; height: 450px;">
                    <div class="card-header" style="font-weight: bold;">Stagiaires par Etablissement</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="stagiairesParEtablissementChart" style="max-width: 70%; max-height: 90%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="border: 2px solid #007BFF; height: 450px;">
                    <div class="card-header" style="font-weight: bold;">Demandes par Mois</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="demandesPerMonthChart" style="max-width: 100%; max-height: 90%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card" style="border: 2px solid #007BFF;">
                <div class="card-header" style="font-weight: bold;">Total des Entretiens</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $totalEntretiens }}</h3>
                    <i class="ti ti-files" style="font-size: 26px; color: #007BFF;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border: 2px solid #28A745;">
                <div class="card-header" style="font-weight: bold;">Entretiens Approuvés</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $approvedEntretiens }}</h3>
                    <i class="ti ti-circle-check" style="font-size: 26px; color: #28A745;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border: 2px solid #DC3545;">
                <div class="card-header" style="font-weight: bold;">Entretiens Refusés</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $refusedEntretiens }}</h3>
                    <i class="ti ti-trash" style="font-size: 26px; color: #DC3545;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border: 2px solid #FFC107;">
                <div class="card-header" style="font-weight: bold;">Entretiens en attente</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $pendingEntretiens }}</h3>
                    <i class="ti ti-clock-pause" style="font-size: 26px; color: #FFC107;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="border: 2px solid #2b50b8; height: 450px;">
                <div class="card-header" style="font-weight: bold;">Status des Entretiens</div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="entretiensStatusChart" style="max-width: 70%; max-height: 90%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart for Demandes par Etablissement
            var etablissementData = {
                labels: @json($etablissements->pluck('etablissement')),
                datasets: [{
                    label: 'Demandes par Etablissement',
                    data: @json($etablissements->pluck('total')),
                    backgroundColor: [
                        '#007BFF', // Bright Blue
                        '#28A745', // Green
                        '#DC3545', // Red
                        '#FFC107', // Yellow
                        '#6C757D', // Gray
                        '#17A2B8', // Teal Blue
                        '#FF5733', // Bright Orange
                        '#8E44AD', // Deep Purple
                        '#2ECC71', // Bright Green
                        '#E74C3C', // Vibrant Red
                        '#3498DB', // Light Blue
                        '#F39C12', // Rich Yellow
                    ],
                }]
            };

            var statusData = {
                labels: ['Approuvées', 'Refusées', 'En attente'],
                datasets: [{
                    label: 'Statut des Demandes',
                    data: [
                        {{ $approvedDemandes }},
                        {{ $refusedDemandes }},
                        {{ $pendingDemandes }},
                    ],
                    backgroundColor: [
                        '#28A745',
                        '#DC3545',
                        '#FFC107',
                    ],
                }]
            };

            new Chart(document.getElementById('etablissementChart').getContext('2d'), {
                type: 'pie',
                data: etablissementData,
            });

            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'bar',
                data: statusData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var demandesPerMonthData = {
                labels: @json(
                    $demandesParMois->map(function ($item) {
                        return $item->month . ' ' . $item->year;
                    })),
                datasets: [{
                    label: 'Demandes Par Mois',
                    data: @json($demandesParMois->pluck('count')),
                    backgroundColor: '#007BFF',
                }]
            };

            // Create the bar chart
            new Chart(document.getElementById('demandesPerMonthChart').getContext('2d'), {
                type: 'bar',
                data: demandesPerMonthData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Stagiaires par Etablissement
            var stagiairesParEtablissementData = {
                labels: @json($stagiairesParEtablissement->pluck('etablissement')),
                datasets: [{
                    label: 'Stagiaires par Etablissement',
                    data: @json($stagiairesParEtablissement->pluck('total')),
                    backgroundColor: [
                        '#007BFF',
                        '#28A745',
                        '#DC3545',
                        '#FFC107',
                        '#6C757D',
                        '#17A2B8',
                    ],
                }]
            };

            new Chart(document.getElementById('stagiairesParEtablissementChart').getContext('2d'), {
                type: 'doughnut',
                data: stagiairesParEtablissementData,
            });
        });

        var entretiensStatusData = {
            labels: ['Approuvés', 'Refusés', 'En attente'],
            datasets: [{
                label: 'Statut des Entretiens',
                data: [
                    {{ $approvedEntretiens }},
                    {{ $refusedEntretiens }},
                    {{ $pendingEntretiens }},
                ],
                backgroundColor: [
                    '#28A745', // Approuvés
                    '#DC3545', // Refusés
                    '#FFC107', // En attente
                ],
            }]
        };

        new Chart(document.getElementById('entretiensStatusChart').getContext('2d'), {
            type: 'bar',
            data: entretiensStatusData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
