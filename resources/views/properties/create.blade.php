@extends('layouts.layout')

@section('title', 'Ajouter une propriété')

@section('styles')
<style>
  /* ════════════════════════════════════════
     TOKENS — alignés sur le nouveau layout
  ════════════════════════════════════════ */
  :root {
    --c-gold:     #c5a055;
    --c-gold-l:   #e2c07a;
    --c-gold-dim: rgba(197,160,85,0.12);
    --c-surface:  #0d1018;
    --c-surface2: #111420;
    --c-surface3: #161924;
    --c-border:   rgba(255,255,255,0.055);
    --c-border-g: rgba(197,160,85,0.2);
    --c-text:     #f0ede8;
    --c-soft:     #a8a49e;
    --c-muted:    #50535c;
    --c-success:  #3db97a;
    --c-danger:   #d95f5f;
    --c-warning:  #e0a030;
    --c-blue:     #5585e0;
    --c-radius:   14px;
    --c-radius-sm:9px;
    --tr:         0.26s cubic-bezier(0.4,0,0.2,1);
  }

  .create-zone {
    font-family: 'Inter', sans-serif;
    animation: zoneIn 0.5s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes zoneIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ════════════════ PAGE HEADER ════════════════ */
  .page-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 36px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--c-border);
    position: relative;
  }

  .page-head::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0;
    width: 120px; height: 1px;
    background: linear-gradient(90deg, var(--c-gold), transparent);
    opacity: 0.5;
  }

  .page-eyebrow {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--c-gold); margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
  }

  .page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1px;
    background: var(--c-gold); opacity: 0.6;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--c-text); margin: 0;
    letter-spacing: 0.02em; line-height: 1.1;
  }

  .page-subtitle {
    font-size: 0.82rem; color: var(--c-muted);
    margin-top: 6px; letter-spacing: 0.02em;
  }

  .btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 50px;
    border: 1px solid var(--c-border);
    background: transparent; color: var(--c-soft);
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem; font-weight: 500;
    text-decoration: none; transition: all 0.22s ease;
    align-self: center;
  }

  .btn-back:hover {
    border-color: var(--c-border-g); color: var(--c-gold);
    background: var(--c-gold-dim);
  }

  /* ════════════════ FORM LAYOUT ════════════════ */
  .form-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 22px;
    align-items: start;
  }

  /* ════════════════ SECTION CARD ════════════════ */
  .section-card {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius);
    padding: 28px;
    margin-bottom: 20px;
    position: relative; overflow: hidden;
    opacity: 0; animation: fadeUp 0.45s ease forwards;
  }

  .section-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, var(--c-gold), transparent);
    opacity: 0.18;
  }

  .section-card:nth-child(1) { animation-delay: 0.06s; }
  .section-card:nth-child(2) { animation-delay: 0.12s; }
  .section-card:nth-child(3) { animation-delay: 0.18s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .section-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 24px; padding-bottom: 18px;
    border-bottom: 1px solid var(--c-border);
    position: relative;
  }

  .section-header::after {
    content: '';
    position: absolute; bottom: -1px; left: 0;
    width: 60px; height: 1px;
    background: var(--c-gold); opacity: 0.5;
  }

  .section-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
    background: var(--c-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    color: var(--c-gold);
  }

  .section-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem; font-weight: 700;
    color: var(--c-text); margin: 0;
    letter-spacing: 0.02em;
  }

  /* ════════════════ FORM ELEMENTS ════════════════ */
  .form-group { margin-bottom: 18px; }

  .form-label {
    display: block;
    font-size: 0.75rem; font-weight: 600;
    color: var(--c-soft); margin-bottom: 8px;
    letter-spacing: 0.06em; text-transform: uppercase;
  }

  .form-label .req { color: var(--c-danger); margin-left: 3px; }

  .form-input,
  .form-select,
  .form-textarea {
    width: 100%;
    padding: 11px 15px;
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius-sm);
    font-size: 0.875rem;
    color: var(--c-text);
    background: var(--c-surface2);
    font-family: 'Inter', sans-serif;
    transition: all 0.22s ease;
    appearance: none;
  }

  .form-input::placeholder,
  .form-textarea::placeholder { color: var(--c-muted); }

  .form-input:focus,
  .form-select:focus,
  .form-textarea:focus {
    outline: none;
    border-color: var(--c-border-g);
    box-shadow: 0 0 0 3px rgba(197,160,85,0.08);
    background: var(--c-surface3);
    color: var(--c-text);
  }

  .form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2350535c' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
    cursor: pointer;
  }

  .form-select option { background: var(--c-surface2); color: var(--c-text); }

  .form-textarea {
    resize: vertical; min-height: 110px; line-height: 1.6;
  }

  .form-hint {
    font-size: 0.72rem; color: var(--c-muted);
    margin-top: 6px; letter-spacing: 0.02em;
  }

  /* Input validation states */
  .form-input.is-invalid,
  .form-select.is-invalid,
  .form-textarea.is-invalid {
    border-color: rgba(217,95,95,0.5);
    box-shadow: 0 0 0 3px rgba(217,95,95,0.08);
  }

  .invalid-msg {
    color: var(--c-danger);
    font-size: 0.72rem; margin-top: 6px;
    display: flex; align-items: center; gap: 5px;
  }

  /* Form rows */
  .form-row { display: grid; gap: 16px; }
  .form-row.cols-2 { grid-template-columns: repeat(2, 1fr); }
  .form-row.cols-3 { grid-template-columns: repeat(3, 1fr); }

  /* Input with icon */
  .input-wrap {
    position: relative;
  }

  .input-wrap i {
    position: absolute; left: 14px; top: 50%;
    transform: translateY(-50%);
    color: var(--c-muted); font-size: 14px;
    pointer-events: none; z-index: 1;
  }

  .input-wrap .form-input { padding-left: 40px; }

  /* ════════════════ UPLOAD CARD ════════════════ */
  .upload-card {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: var(--c-radius);
    overflow: hidden;
    position: sticky; top: 24px;
    opacity: 0; animation: fadeUp 0.45s ease 0.08s forwards;
  }

  .upload-head {
    padding: 18px 22px;
    border-bottom: 1px solid var(--c-border);
    display: flex; align-items: center; gap: 12px;
    position: relative;
  }

  .upload-head::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, var(--c-gold), transparent 60%);
    opacity: 0.3;
  }

  .upload-head-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    background: var(--c-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    color: var(--c-gold);
  }

  .upload-head h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.05rem; font-weight: 700;
    color: var(--c-text); margin: 0; letter-spacing: 0.02em;
  }

  .upload-body { padding: 22px; }

  /* Drop zone */
  .drop-zone {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 32px 20px;
    border: 1px dashed rgba(197,160,85,0.25);
    border-radius: var(--c-radius-sm);
    cursor: pointer;
    transition: all 0.25s ease;
    background: var(--c-surface2);
    text-align: center; position: relative;
  }

  .drop-zone:hover,
  .drop-zone.dragover {
    border-color: rgba(197,160,85,0.5);
    background: var(--c-gold-dim);
  }

  .drop-zone-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--c-gold-dim);
    border: 1px solid rgba(197,160,85,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--c-gold);
    margin-bottom: 14px;
    transition: all 0.25s ease;
  }

  .drop-zone:hover .drop-zone-icon {
    box-shadow: 0 0 20px rgba(197,160,85,0.2);
    transform: translateY(-2px);
  }

  .drop-zone-text {
    font-size: 0.855rem; font-weight: 500;
    color: var(--c-soft); margin-bottom: 4px;
  }

  .drop-zone-hint {
    font-size: 0.72rem; color: var(--c-muted);
  }

  .file-input {
    position: absolute; width: 0; height: 0; opacity: 0;
  }

  .upload-meta {
    font-size: 0.72rem; color: var(--c-muted);
    margin-top: 14px; line-height: 1.6;
    display: flex; align-items: flex-start; gap: 6px;
  }

  .upload-meta i { color: var(--c-gold); flex-shrink: 0; margin-top: 2px; }

  /* Preview */
  .preview-section { margin-top: 20px; }

  .preview-label {
    font-size: 0.65rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--c-muted); margin-bottom: 12px;
    display: flex; align-items: center; gap: 8px;
  }

  .preview-label::after {
    content: ''; flex: 1; height: 1px; background: var(--c-border);
  }

  .preview-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }

  .preview-item {
    position: relative; border-radius: 10px;
    overflow: hidden; aspect-ratio: 1;
    background: var(--c-surface2);
    border: 1px solid var(--c-border);
  }

  .preview-img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.3s ease;
  }

  .preview-item:hover .preview-img { transform: scale(1.04); }

  .preview-overlay {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(8,10,15,0.88), transparent);
    padding: 8px;
  }

  .preview-name {
    font-size: 0.67rem; font-weight: 600; color: var(--c-text);
    margin-bottom: 1px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }

  .preview-size {
    font-size: 0.6rem; color: var(--c-muted);
  }

  /* ════════════════ ACTION BUTTONS ════════════════ */
  .action-buttons {
    display: flex; flex-direction: column;
    gap: 10px; margin-top: 18px;
  }

  .btn-submit {
    width: 100%;
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 13px 24px;
    border-radius: 50px;
    border: 1px solid var(--c-gold);
    background: transparent; color: var(--c-gold);
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem; font-weight: 600;
    cursor: pointer; transition: all 0.25s ease;
    position: relative; overflow: hidden;
    letter-spacing: 0.04em;
  }

  .btn-submit::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--c-gold), var(--c-gold-l));
    opacity: 0; transition: opacity 0.25s ease;
  }

  .btn-submit span, .btn-submit i { position: relative; z-index: 1; }
  .btn-submit:hover::before { opacity: 1; }
  .btn-submit:hover { color: #080a0f; box-shadow: 0 0 22px rgba(197,160,85,0.3); }
  .btn-submit:disabled { opacity: 0.55; cursor: not-allowed; }

  .btn-cancel {
    width: 100%;
    display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 12px 24px;
    border-radius: 50px;
    border: 1px solid var(--c-border);
    background: transparent; color: var(--c-muted);
    font-family: 'Inter', sans-serif;
    font-size: 0.855rem; font-weight: 500;
    text-decoration: none; cursor: pointer;
    transition: all 0.22s ease;
  }

  .btn-cancel:hover {
    border-color: var(--c-border-g); color: var(--c-soft);
    background: rgba(255,255,255,0.03);
  }

  /* ════════════════ RESPONSIVE ════════════════ */
  @media (max-width: 1100px) {
    .form-grid { grid-template-columns: 1fr; }
    .upload-card { position: static; }
    .action-buttons { flex-direction: row; }
    .btn-submit, .btn-cancel { flex: 1; }
  }

  @media (max-width: 768px) {
    .form-row.cols-2,
    .form-row.cols-3 { grid-template-columns: 1fr; }
    .page-head { flex-direction: column; }
  }

  @media (max-width: 576px) {
    .section-card { padding: 20px; }
    .upload-body  { padding: 16px; }
    .preview-grid { grid-template-columns: 1fr; }
    .action-buttons { flex-direction: column; }
    .page-title { font-size: 1.65rem; }
  }
</style>
@endsection

@section('content')
<div class="create-zone">

  {{-- ════════ HEADER ════════ --}}
  <div class="page-head">
    <div>
      <h1 class="page-title">Ajouter une propriété</h1>
      <p class="page-subtitle">Complétez les informations pour publier une nouvelle propriété</p>
    </div>
    <a href="{{ route('properties.index') }}" class="btn-back">
      <i class="bi bi-arrow-left"></i>
      <span>Retour à la liste</span>
    </a>
  </div>

  <form id="propertyForm"
        action="{{ route('properties.store') }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf

    <div class="form-grid">

      {{-- ════════ COLONNE PRINCIPALE ════════ --}}
      <div>

        {{-- Section 1 : Informations de base --}}
        <div class="section-card">
          <div class="section-header">
            <div class="section-icon"><i class="bi bi-info-circle"></i></div>
            <h2>Informations de base</h2>
          </div>

          <div class="form-row cols-2">
            <div class="form-group">
              <label class="form-label">Titre <span class="req">*</span></label>
              <input type="text" class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                     name="title" value="{{ old('title') }}"
                     placeholder="Ex : Magnifique villa avec piscine" required>
              @error('title')
                <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Type <span class="req">*</span></label>
              <select class="form-select {{ $errors->has('type') ? 'is-invalid' : '' }}"
                      name="type" required>
                <option value="">Sélectionner un type</option>
                <option value="maison"       {{ old('type') == 'maison'       ? 'selected' : '' }}>Maison</option>
                <option value="appartement"  {{ old('type') == 'appartement'  ? 'selected' : '' }}>Appartement</option>
                <option value="terrain"      {{ old('type') == 'terrain'      ? 'selected' : '' }}>Terrain</option>
                <option value="bureau"       {{ old('type') == 'bureau'       ? 'selected' : '' }}>Bureau</option>
              </select>
              @error('type')
                <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-textarea" name="description"
                      placeholder="Décrivez la propriété en détail…">{{ old('description') }}</textarea>
            <div class="form-hint">Mettez en valeur les atouts de la propriété</div>
          </div>

          <div class="form-row cols-3">
            <div class="form-group">
              <label class="form-label">Prix (Ar) <span class="req">*</span></label>
              <div class="input-wrap">
                <i class="bi bi-cash-coin"></i>
                <input type="number" class="form-input {{ $errors->has('price') ? 'is-invalid' : '' }}"
                       name="price" value="{{ old('price') }}"
                       min="0" step="1" placeholder="0" required>
              </div>
              @error('price')
                <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Surface (m²)</label>
              <div class="input-wrap">
                <i class="bi bi-aspect-ratio"></i>
                <input type="number" class="form-input"
                       name="surface" value="{{ old('surface') }}"
                       min="0" placeholder="0">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Statut</label>
              <select class="form-select" name="status">
                <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="vendu"      {{ old('status') == 'vendu'      ? 'selected' : '' }}>Vendu</option>
                <option value="loué"       {{ old('status') == 'loué'       ? 'selected' : '' }}>Loué</option>
              </select>
            </div>
          </div>
        </div>

        {{-- Section 2 : Localisation --}}
        <div class="section-card">
          <div class="section-header">
            <div class="section-icon"><i class="bi bi-geo-alt"></i></div>
            <h2>Localisation</h2>
          </div>

          <div class="form-row cols-2">
            <div class="form-group">
              <label class="form-label">Ville <span class="req">*</span></label>
              <div class="input-wrap">
                <i class="bi bi-building"></i>
                <input type="text" class="form-input {{ $errors->has('city') ? 'is-invalid' : '' }}"
                       name="city" value="{{ old('city') }}"
                       placeholder="Ex : Antananarivo" required>
              </div>
              @error('city')
                <div class="invalid-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">Adresse</label>
              <div class="input-wrap">
                <i class="bi bi-signpost"></i>
                <input type="text" class="form-input"
                       name="address" value="{{ old('address') }}"
                       placeholder="Ex : Lot II M 45 Bis Ankadivato">
              </div>
            </div>
          </div>
        </div>

        {{-- Section 3 : Caractéristiques --}}
        <div class="section-card">
          <div class="section-header">
            <div class="section-icon"><i class="bi bi-house-door"></i></div>
            <h2>Caractéristiques</h2>
          </div>

          <div class="form-row cols-2">
            <div class="form-group">
              <label class="form-label">Nombre de pièces</label>
              <div class="input-wrap">
                <i class="bi bi-door-open"></i>
                <input type="number" class="form-input"
                       name="rooms" value="{{ old('rooms') }}"
                       min="0" placeholder="0">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Salles de bain</label>
              <div class="input-wrap">
                <i class="bi bi-droplet"></i>
                <input type="number" class="form-input"
                       name="bathrooms" value="{{ old('bathrooms') }}"
                       min="0" placeholder="0">
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- ════════ SIDEBAR ════════ --}}
      <div>

        {{-- Upload d'images --}}
        <div class="upload-card">
          <div class="upload-head">
            <div class="upload-head-icon"><i class="bi bi-images"></i></div>
            <h3>Photos de la propriété</h3>
          </div>
          <div class="upload-body">

            <label for="images" class="drop-zone" id="dropZone">
              <div class="drop-zone-icon">
                <i class="bi bi-cloud-upload"></i>
              </div>
              <div class="drop-zone-text">Cliquez pour ajouter des photos</div>
              <div class="drop-zone-hint">ou glissez-déposez vos fichiers ici</div>
              <input type="file" class="file-input" id="images"
                     name="images[]" multiple accept="image/*">
            </label>

            <div class="upload-meta">
              <i class="bi bi-info-circle"></i>
              <span>Formats acceptés : JPEG, PNG, JPG, GIF, WebP<br>Taille max : 2 MB par image</span>
            </div>

            <div id="previewSection" class="preview-section" style="display:none;">
              <div class="preview-label">Aperçu</div>
              <div id="imagePreview" class="preview-grid"></div>
            </div>

          </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="action-buttons">
          <button type="submit" class="btn-submit" id="submitBtn">
            <i class="bi bi-check-lg"></i>
            <span>Créer la propriété</span>
          </button>
          <a href="{{ route('properties.index') }}" class="btn-cancel">
            <i class="bi bi-x-lg"></i>
            <span>Annuler</span>
          </a>
        </div>

      </div>
    </div>
  </form>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const imageInput   = document.getElementById('images');
  const imagePreview = document.getElementById('imagePreview');
  const previewSec   = document.getElementById('previewSection');
  const dropZone     = document.getElementById('dropZone');

  /* ── Aperçu des images ── */
  imageInput.addEventListener('change', function () {
    renderPreviews(this.files);
  });

  function renderPreviews(files) {
    imagePreview.innerHTML = '';
    if (!files || files.length === 0) {
      previewSec.style.display = 'none';
      return;
    }
    previewSec.style.display = 'block';

    Array.from(files).forEach(file => {
      if (!file.type.match('image.*')) return;
      const reader = new FileReader();
      reader.onload = e => {
        const item = document.createElement('div');
        item.className = 'preview-item';
        item.innerHTML = `
          <img src="${e.target.result}" class="preview-img" alt="Aperçu">
          <div class="preview-overlay">
            <div class="preview-name">${file.name}</div>
            <div class="preview-size">${(file.size / 1024).toFixed(1)} KB</div>
          </div>`;
        imagePreview.appendChild(item);
      };
      reader.readAsDataURL(file);
    });
  }

  /* ── Drag & Drop ── */
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => {
    dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); });
  });

  ['dragenter', 'dragover'].forEach(ev => {
    dropZone.addEventListener(ev, () => dropZone.classList.add('dragover'));
  });

  ['dragleave', 'drop'].forEach(ev => {
    dropZone.addEventListener(ev, () => dropZone.classList.remove('dragover'));
  });

  dropZone.addEventListener('drop', function (e) {
    imageInput.files = e.dataTransfer.files;
    renderPreviews(imageInput.files);
  });

  /* ── Validation & submit loader ── */
  document.getElementById('propertyForm').addEventListener('submit', function (e) {
    const price = parseFloat(document.querySelector('[name="price"]').value);
    if (price < 0) {
      e.preventDefault();
      alert('Le prix ne peut pas être négatif.');
      return;
    }
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> <span>Création en cours…</span>';
    btn.disabled = true;
  });

});
</script>
@endsection