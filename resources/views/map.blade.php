<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Volunteer Map - Shongjukto</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .toolbar { 
            display:flex; 
            gap:12px; 
            align-items:center; 
            padding:20px; 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            margin: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        .title { 
            font-weight:700; 
            color:#1b4332; 
            font-size:1.5rem; 
            margin: 0;
        }
        #map { 
            height: 75vh; 
            margin: 0 16px 16px 16px; 
            border-radius: 20px; 
            box-shadow: 0 12px 40px rgba(0,0,0,0.15); 
            border: 2px solid rgba(255,255,255,0.2);
        }
        .legend { 
            background: rgba(255,255,255,0.95); 
            padding: 20px 24px; 
            border-radius: 16px; 
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            margin: 16px;
            min-width: 280px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 4px 0;
        }
        .legend span { 
            display: inline-block; 
            width: 18px; 
            height: 18px; 
            border-radius: 50%; 
            margin-right: 16px; 
            border: 2px solid rgba(255,255,255,0.8);
            flex-shrink: 0;
        }
        .filter-pill { 
            border-radius: 25px; 
            padding: 8px 16px; 
            font-weight:600; 
            border: 2px solid;
            transition: all 0.3s ease;
        }
        .filter-pill.active { 
            background: #2d6a4f; 
            color: #fff; 
            border-color: #2d6a4f;
            transform: scale(1.05);
        }
        .filter-pill:hover {
            transform: scale(1.05);
        }
        .btn-custom {
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="toolbar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a class="btn btn-outline-primary btn-custom" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Home
                </a>
                <span class="title">🔍 Volunteer Map Dashboard</span>
            </div>
            <div class="d-flex gap-2">
                <a id="filter-help" class="btn btn-outline-danger filter-pill active" href="javascript:void(0)">
                    🆘 Help Requests
                </a>
                <a id="filter-donations" class="btn btn-outline-primary filter-pill active" href="javascript:void(0)">
                    📦 Donations
                </a>
            </div>
        </div>
    </div>

    <div class="legend">
        <h6 class="mb-3 fw-bold">📊 Map Legend</h6>
        <div class="legend-item">
            <span style="background: #dc3545;"></span>
            <span class="fw-semibold">Help Requests</span>
        </div>
        <div class="legend-item">
            <span style="background: #0d6efd;"></span>
            <span class="fw-semibold">Donations</span>
        </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const map = L.map('map').setView([23.7808875, 90.2792371], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const markersLayer = L.layerGroup().addTo(map);
        let showHelp = true;
        let showDonations = true;

        const colors = {
            help: '#dc3545',      // Red for help requests
            donation: '#0d6efd'   // Blue for donations
        };

        function createMarker(lat, lng, color, popupHtml) {
            const icon = L.circleMarker([lat, lng], {
                radius: 10,
                color: color,
                fillColor: color,
                fillOpacity: 0.8,
                weight: 2
            });
            icon.bindPopup(popupHtml, {
                maxWidth: 300,
                className: 'custom-popup'
            });
            return icon;
        }

        async function loadData() {
            try {
                const res = await fetch('{{ route('map.data') }}');
                const data = await res.json();
                markersLayer.clearLayers();

                (data.helpRequests || []).forEach(h => {
                    if (!h.latitude || !h.longitude) return;
                    const html = `
                        <div style="min-width: 250px;">
                            <h6 style="color: #dc3545; margin-bottom: 8px;">🆘 Help Request</h6>
                            <p><strong>Category:</strong> ${h.category}</p>
                            ${h.description ? `<p><strong>Description:</strong> ${h.description}</p>` : ''}
                            <p><strong>Status:</strong> <span class="badge bg-${h.status === 'pending' ? 'warning' : h.status === 'accepted' ? 'success' : 'secondary'}">${h.status}</span></p>
                            ${h.address ? `<p><strong>📍 Address:</strong> ${h.address}</p>` : ''}
                            <small class="text-muted">Created: ${new Date(h.created_at).toLocaleDateString()}</small>
                        </div>
                    `;
                    if (showHelp) createMarker(parseFloat(h.latitude), parseFloat(h.longitude), colors.help, html).addTo(markersLayer);
                });

                (data.donations || []).forEach(d => {
                    if (!d.latitude || !d.longitude) return;
                    const html = `
                        <div style="min-width: 250px;">
                            <h6 style="color: #0d6efd; margin-bottom: 8px;">📦 Donation</h6>
                            <p><strong>Item:</strong> ${d.item}</p>
                            <p><strong>Quantity:</strong> ${d.quantity || 'Not specified'}</p>
                            <p><strong>Status:</strong> <span class="badge bg-${d.status === 'pending' ? 'warning' : d.status === 'accepted' ? 'success' : 'secondary'}">${d.status}</span></p>
                            ${d.address ? `<p><strong>📍 Address:</strong> ${d.address}</p>` : ''}
                            ${d.scheduled_date ? `<p><strong>📅 Scheduled:</strong> ${d.scheduled_date} at ${d.scheduled_time}</p>` : ''}
                        </div>
                    `;
                    if (showDonations) createMarker(parseFloat(d.latitude), parseFloat(d.longitude), colors.donation, html).addTo(markersLayer);
                });
            } catch (e) {
                console.error('Error loading map data:', e);
            }
        }

        loadData();
        setInterval(loadData, 15000);

        function toggleActive(el) { 
            el.classList.toggle('active'); 
        }
        
        document.getElementById('filter-help').addEventListener('click', (e) => {
            toggleActive(e.target); 
            showHelp = e.target.classList.contains('active'); 
            loadData();
        });
        
        document.getElementById('filter-donations').addEventListener('click', (e) => {
            toggleActive(e.target); 
            showDonations = e.target.classList.contains('active'); 
            loadData();
        });
    </script>
</body>
</html>


