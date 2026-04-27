<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - LogisFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Registro de Nuevo Usuario - LogisFood</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <hr>
                        <h5 class="mb-3 text-primary">Información Geográfica</h5>

                        <div class="mb-4">
                            <label for="pais" class="form-label">País de Residencia</label>
                            <select name="pais" id="pais" class="form-select" required>
                                <option value="">Cargando países...</option>
                            </select>
                        </div>

                        <div id="info-pais-card" class="card mb-4 border-primary" style="display: none;">
                            <div class="card-body bg-light">
                                <div class="d-flex align-items-center mb-3">
                                    <img id="flag-img" src="" alt="Bandera" width="60" class="me-3 border shadow-sm">
                                    <h5 id="country-name" class="mb-0 text-primary">Nombre del País</h5>
                                </div>
                                <ul class="list-unstyled mb-0" style="font-size: 0.95em;">
                                    <li class="mb-1"><strong>🏛️ Capital:</strong> <span id="capital-text"></span></li>
                                    <li class="mb-1"><strong>💰 Moneda:</strong> <span id="currency-text"></span></li>
                                    <li class="mb-1"><strong>🗣️ Idioma(s):</strong> <span id="language-text"></span></li>
                                    <li><strong>⏰ Zona Horaria:</strong> <span id="timezone-text"></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">Crear Cuenta</button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">Ya tengo cuenta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPais = document.getElementById('pais');
    const infoCard = document.getElementById('info-pais-card');
    let listaPaises = []; 

    fetch('https://restcountries.com/v3.1/all?fields=name,cca2,capital,currencies,languages,timezones,flags')
        .then(response => response.json())
        .then(data => {
            listaPaises = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            
            selectPais.innerHTML = '<option value="">Selecciona tu país...</option>';
            listaPaises.forEach(pais => {
                let option = document.createElement('option');
                option.value = pais.cca2; 
                option.textContent = pais.name.common;
                selectPais.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error API:', error);
            selectPais.innerHTML = '<option value="">Error al cargar países</option>';
        });

    selectPais.addEventListener('change', function() {
        const codigo = this.value;
        if (!codigo) {
            infoCard.style.display = 'none'; 
            return;
        }

        const pData = listaPaises.find(p => p.cca2 === codigo);
        if (pData) {
            const capital = pData.capital && pData.capital.length > 0 ? pData.capital[0] : 'N/A';
            let moneda = 'N/A';
            if (pData.currencies) {
                const cData = Object.values(pData.currencies)[0];
                moneda = `${cData.name} (${cData.symbol})`;
            }
            const idiomas = pData.languages ? Object.values(pData.languages).join(', ') : 'N/A';
            const zonas = pData.timezones ? pData.timezones.join(', ') : 'N/A';

            document.getElementById('flag-img').src = pData.flags.svg;
            document.getElementById('country-name').textContent = pData.name.common;
            document.getElementById('capital-text').textContent = capital;
            document.getElementById('currency-text').textContent = moneda;
            document.getElementById('language-text').textContent = idiomas;
            document.getElementById('timezone-text').textContent = zonas;

            infoCard.style.display = 'block';
        }
    });
});
</script>
</body>
</html>