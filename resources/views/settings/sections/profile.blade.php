{{--
  resources/views/settings/sections/profile.blade.php
  Inclus depuis settings/index.blade.php — $user est passé par SettingsController@index
--}}

<div class="settings-card">

  {{-- HEADER --}}
  <div class="settings-card-header">
    <h2 class="settings-card-title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
      Mon Profil
    </h2>
    <button class="btn-edit" id="editProfileBtn" type="button">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
      </svg>
      Modifier
    </button>
  </div>

  <div class="card-body" style="padding: 36px;">

    {{-- ALERTE SUCCÈS --}}
    @if(session('success'))
    <div class="alert alert-success" id="alertSuccess" style="display:flex;align-items:flex-start;gap:12px;padding:14px 18px;border-radius:10px;font-size:.875rem;margin-bottom:28px;background:rgba(76,175,125,.1);border:1px solid rgba(76,175,125,.25);color:#7de0a8;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
      <button onclick="this.parentElement.style.display='none'" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;opacity:.6;font-size:1.1rem;">&times;</button>
    </div>
    @endif

    {{-- ALERTE ERREURS --}}
    @if($errors->any())
    <div class="alert alert-danger" style="display:flex;align-items:flex-start;gap:12px;padding:14px 18px;border-radius:10px;font-size:.875rem;margin-bottom:28px;background:rgba(224,92,92,.1);border:1px solid rgba(224,92,92,.25);color:#f08080;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      <div>
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
      <button onclick="this.parentElement.style.display='none'" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;opacity:.6;font-size:1.1rem;">&times;</button>
    </div>
    @endif

    {{-- FORMULAIRE --}}
    <form id="profileForm"
          action="{{ route('settings.profile.update') }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      {{-- AVATAR --}}
      <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:40px;">
        <div style="position:relative;display:inline-block;">
          <div style="width:128px;height:128px;border-radius:50%;padding:3px;background:linear-gradient(135deg,#c9a96e,rgba(201,169,110,.3));box-shadow:0 0 30px rgba(201,169,110,.2);">
            <img id="avatarPreview"
             src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(($user->first_name ?? '').' '.($user->last_name ?? '')).'&background=1a1e28&color=c9a96e&size=128&font-size=0.4&bold=true' }}"
              style="width:100%;height:100%;border-radius:50%;object-fit:cover;background:#1a1e28;display:block;">
          </div>
          <label for="avatarInput" id="avatarChangeBtn" title="Changer la photo"
            style="position:absolute;bottom:4px;right:4px;width:36px;height:36px;border-radius:50%;background:#c9a96e;border:2px solid #13161d;display:none;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 10px rgba(0,0,0,.4);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0d0f14" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
              <circle cx="12" cy="13" r="4"/>
            </svg>
          </label>
        </div>
        <p id="avatarHelpText" style="font-size:.75rem;color:#6b7080;margin-top:12px;display:none;text-align:center;">
          Cliquez sur l'icône pour changer votre photo (JPG, PNG — max 2 Mo)
        </p>
      </div>

      <input type="file"   id="avatarInput"  name="avatar"        accept="image/*" disabled style="display:none;">
      <input type="hidden" id="avatarBase64" name="avatar_base64" value="">

      {{-- CHAMPS --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px 28px;">

        <div style="display:flex;flex-direction:column;gap:8px;">
          <label style="font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:#6b7080;">
            Prénom <span style="color:#c9a96e;">*</span>
          </label>
          <input type="text" name="first_name"
            value="{{ old('first_name', $user->first_name) }}"
            required readonly placeholder="Votre prénom"
            style="width:100%;background:#1a1e28;border:1.5px solid #252a38;border-radius:10px;padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#e8e6e1;outline:none;">
        </div>

        <div style="display:flex;flex-direction:column;gap:8px;">
          <label style="font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:#6b7080;">
            Nom <span style="color:#c9a96e;">*</span>
          </label>
          <input type="text" name="last_name"
            value="{{ old('last_name', $user->last_name) }}"
            required readonly placeholder="Votre nom"
            style="width:100%;background:#1a1e28;border:1.5px solid #252a38;border-radius:10px;padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#e8e6e1;outline:none;">
        </div>

        <div style="display:flex;flex-direction:column;gap:8px;">
          <label style="font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:#6b7080;">
            Email <span style="color:#c9a96e;">*</span>
          </label>
          <input type="email" name="email"
            value="{{ old('email', $user->email) }}"
            required readonly placeholder="votre@email.com"
            style="width:100%;background:#1a1e28;border:1.5px solid #252a38;border-radius:10px;padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#e8e6e1;outline:none;">
        </div>

        <div style="display:flex;flex-direction:column;gap:8px;">
          <label style="font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:#6b7080;">
            Téléphone
          </label>
          <input type="tel" name="phone"
            value="{{ old('phone', $user->phone) }}"
            readonly placeholder="+33 6 00 00 00 00"
            style="width:100%;background:#1a1e28;border:1.5px solid #252a38;border-radius:10px;padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#e8e6e1;outline:none;">
        </div>

        <div style="display:flex;flex-direction:column;gap:8px;grid-column:1/-1;">
          <label style="font-size:.72rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:#6b7080;">
            Bio / Description
          </label>
          <textarea name="bio" readonly placeholder="Présentez-vous en quelques mots…"
            style="width:100%;background:#1a1e28;border:1.5px solid #252a38;border-radius:10px;padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#e8e6e1;outline:none;resize:none;min-height:96px;">{{ old('bio', $user->bio) }}</textarea>
        </div>

        {{-- BOUTONS D'ACTION --}}
        <div id="editButtons" style="grid-column:1/-1;display:none;align-items:center;gap:14px;padding-top:24px;border-top:1px solid #252a38;margin-top:8px;">
          <button type="submit" id="submitBtn"
            style="display:flex;align-items:center;gap:8px;padding:12px 28px;border-radius:50px;border:none;background:linear-gradient(135deg,#c9a96e,#e8c97a);color:#0d0f14;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:600;cursor:pointer;">
            <span id="spinner" style="display:none;width:16px;height:16px;border:2px solid rgba(13,15,20,.3);border-top-color:#0d0f14;border-radius:50%;animation:spin .7s linear infinite;"></span>
            <svg id="saveIcon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            Valider les modifications
          </button>
          <button type="button" id="cancelEditBtn"
            style="display:flex;align-items:center;gap:8px;padding:12px 24px;border-radius:50px;border:1.5px solid #252a38;background:transparent;color:#6b7080;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:500;cursor:pointer;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Annuler
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

{{-- MODAL CROP --}}
<div id="cropOverlay" style="position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;z-index:9999;padding:16px;">
  <div style="background:#13161d;border:1px solid #252a38;border-radius:16px;width:100%;max-width:600px;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,.6);">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:22px 28px;border-bottom:1px solid #252a38;">
      <h2 style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:500;color:#e8e6e1;display:flex;align-items:center;gap:9px;margin:0;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 7 16 7 16 14"/><polyline points="1 17 8 17 8 10"/>
          <path d="M3.51 9a9 9 0 1 0 .49-3"/>
        </svg>
        Recadrer votre photo
      </h2>
      <button id="modalCloseBtn" type="button" style="background:none;border:none;cursor:pointer;color:#6b7080;display:flex;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div style="padding:24px 28px;">
      <div style="max-height:360px;overflow:hidden;border-radius:10px;background:#0a0c10;">
        <img id="imageToCrop" style="max-width:100%;display:block;">
      </div>
      <div style="display:flex;justify-content:center;gap:8px;margin-top:16px;">
        <button type="button" id="zoomInBtn"     class="ctrl-btn" title="Zoom avant"       style="width:38px;height:38px;border-radius:50%;border:1.5px solid #252a38;background:#1a1e28;color:#6b7080;cursor:pointer;display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg></button>
        <button type="button" id="zoomOutBtn"    class="ctrl-btn" title="Zoom arrière"     style="width:38px;height:38px;border-radius:50%;border:1.5px solid #252a38;background:#1a1e28;color:#6b7080;cursor:pointer;display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg></button>
        <button type="button" id="rotateLeftBtn" class="ctrl-btn" title="Rotation gauche"  style="width:38px;height:38px;border-radius:50%;border:1.5px solid #252a38;background:#1a1e28;color:#6b7080;cursor:pointer;display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.1"/></svg></button>
        <button type="button" id="rotateRightBtn"class="ctrl-btn" title="Rotation droite"  style="width:38px;height:38px;border-radius:50%;border:1.5px solid #252a38;background:#1a1e28;color:#6b7080;cursor:pointer;display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-.49-3.1"/></svg></button>
        <button type="button" id="resetCropBtn"  class="ctrl-btn" title="Réinitialiser"    style="width:38px;height:38px;border-radius:50%;border:1.5px solid #252a38;background:#1a1e28;color:#6b7080;cursor:pointer;display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/></svg></button>
      </div>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:12px;padding:20px 28px;border-top:1px solid #252a38;">
      <button type="button" id="cancelCropBtn"
        style="display:flex;align-items:center;gap:8px;padding:12px 24px;border-radius:50px;border:1.5px solid #252a38;background:transparent;color:#6b7080;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:500;cursor:pointer;">
        Annuler
      </button>
      <button type="button" id="cropBtn"
        style="display:flex;align-items:center;gap:8px;padding:12px 28px;border-radius:50px;border:none;background:linear-gradient(135deg,#c9a96e,#e8c97a);color:#0d0f14;font-family:'DM Sans',sans-serif;font-size:.875rem;font-weight:600;cursor:pointer;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Valider le recadrage
      </button>
    </div>
  </div>
</div>

{{-- Scripts Cropper + logique formulaire --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<style>
  @keyframes spin { to { transform: rotate(360deg); } }
  .btn-edit {
    display:flex;align-items:center;gap:7px;padding:9px 20px;border-radius:50px;
    border:1.5px solid #c9a96e;background:transparent;color:#c9a96e;
    font-family:'DM Sans',sans-serif;font-size:.82rem;font-weight:500;cursor:pointer;
    transition:all .25s ease;letter-spacing:.03em;
  }
  .btn-edit:hover { background:#c9a96e;color:#0d0f14;box-shadow:0 0 20px rgba(201,169,110,.35); }

  /* Inputs en mode lecture */
  #profileForm input[readonly],
  #profileForm textarea[readonly] {
    background: rgba(255,255,255,0.025) !important;
    color: #6b7080 !important;
    border-color: transparent !important;
    cursor: default;
  }
  /* Inputs en mode édition */
  #profileForm input:not([readonly]):focus,
  #profileForm textarea:not([readonly]):focus {
    border-color: #c9a96e !important;
    box-shadow: 0 0 0 3px rgba(201,169,110,.12) !important;
    background: rgba(201,169,110,.04) !important;
  }
  #profileForm input.invalid,
  #profileForm textarea.invalid {
    border-color: #e05c5c !important;
    box-shadow: 0 0 0 3px rgba(224,92,92,.12) !important;
  }
</style>
<script>
(function() {
  const editProfileBtn  = document.getElementById('editProfileBtn');
  const cancelEditBtn   = document.getElementById('cancelEditBtn');
  const editButtons     = document.getElementById('editButtons');
  const profileForm     = document.getElementById('profileForm');
  const formInputs      = profileForm.querySelectorAll('input:not([type="hidden"]):not([type="file"]), textarea');
  const avatarInput     = document.getElementById('avatarInput');
  const avatarPreview   = document.getElementById('avatarPreview');
  const avatarChangeBtn = document.getElementById('avatarChangeBtn');
  const avatarHelpText  = document.getElementById('avatarHelpText');
  const imageToCrop     = document.getElementById('imageToCrop');
  const cropOverlay     = document.getElementById('cropOverlay');
  const cropBtn         = document.getElementById('cropBtn');
  const cancelCropBtn   = document.getElementById('cancelCropBtn');
  const modalCloseBtn   = document.getElementById('modalCloseBtn');
  const avatarBase64    = document.getElementById('avatarBase64');
  const submitBtn       = document.getElementById('submitBtn');
  const spinner         = document.getElementById('spinner');
  const saveIcon        = document.getElementById('saveIcon');

  let cropper = null;
  let originalValues = {};
  let originalAvatarSrc = avatarPreview.src;
  let isEditMode = false;

  // ✅ Si erreurs de validation, ouvrir automatiquement le mode édition
  @if($errors->any())
    enableEdit();
  @endif

  function saveOriginal() {
    originalValues = {};
    originalAvatarSrc = avatarPreview.src;
    formInputs.forEach(i => originalValues[i.name] = i.value);
  }

  function restoreOriginal() {
    formInputs.forEach(i => {
      if (originalValues[i.name] !== undefined) {
        i.value = originalValues[i.name];
        i.classList.remove('invalid');
      }
    });
    avatarPreview.src = originalAvatarSrc;
    avatarBase64.value = '';
    avatarInput.value  = '';
  }

  function enableEdit() {
    isEditMode = true;
    saveOriginal();
    formInputs.forEach(i => { i.readOnly = false; });
    avatarInput.disabled = false;
    avatarChangeBtn.style.display = 'flex';
    avatarHelpText.style.display  = 'block';
    editButtons.style.display     = 'flex';
    editProfileBtn.style.display  = 'none';
    setTimeout(() => formInputs[0]?.focus(), 80);
  }

  function disableEdit() {
    isEditMode = false;
    formInputs.forEach(i => { i.readOnly = true; i.classList.remove('invalid'); });
    avatarInput.disabled = true;
    avatarChangeBtn.style.display = 'none';
    avatarHelpText.style.display  = 'none';
    editButtons.style.display     = 'none';
    editProfileBtn.style.display  = 'flex';
  }

  editProfileBtn.addEventListener('click', enableEdit);

  cancelEditBtn.addEventListener('click', () => {
    const changed = Array.from(formInputs).some(i => i.value !== originalValues[i.name])
                 || avatarPreview.src !== originalAvatarSrc;
    if (changed && !confirm('Annuler les modifications ?')) return;
    restoreOriginal();
    disableEdit();
  });

  /* AVATAR */
  avatarInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    if (!file.type.match('image.*'))    { alert('Fichier image requis (JPG, PNG…)'); avatarInput.value=''; return; }
    if (file.size > 2*1024*1024)        { alert('Taille max : 2 Mo');               avatarInput.value=''; return; }
    const reader = new FileReader();
    reader.onload = ev => { imageToCrop.src = ev.target.result; openCropModal(); };
    reader.readAsDataURL(file);
  });

  function openCropModal() {
    cropOverlay.style.display = 'flex';
    setTimeout(() => {
      if (cropper) cropper.destroy();
      cropper = new Cropper(imageToCrop, {
        aspectRatio: 1, viewMode: 2, autoCropArea: 1,
        responsive: true, guides: true, highlight: false,
        cropBoxMovable: true, cropBoxResizable: true,
      });
    }, 100);
  }

  function closeCropModal() {
    if (cropper) { cropper.destroy(); cropper = null; }
    cropOverlay.style.display = 'none';
    avatarInput.value = '';
  }

  modalCloseBtn.addEventListener('click', closeCropModal);
  cancelCropBtn.addEventListener('click', closeCropModal);
  cropOverlay.addEventListener('click', e => { if (e.target === cropOverlay) closeCropModal(); });

  document.getElementById('zoomInBtn').addEventListener('click',      () => cropper?.zoom(0.1));
  document.getElementById('zoomOutBtn').addEventListener('click',     () => cropper?.zoom(-0.1));
  document.getElementById('rotateLeftBtn').addEventListener('click',  () => cropper?.rotate(-90));
  document.getElementById('rotateRightBtn').addEventListener('click', () => cropper?.rotate(90));
  document.getElementById('resetCropBtn').addEventListener('click',   () => cropper?.reset());

  cropBtn.addEventListener('click', () => {
    if (!cropper) return;
    const canvas = cropper.getCroppedCanvas({ width: 400, height: 400, imageSmoothingQuality: 'high' });
    if (canvas) {
      const b64 = canvas.toDataURL('image/jpeg', 0.9);
      avatarBase64.value  = b64;
      avatarPreview.src   = b64;
      closeCropModal();
    }
  });

  /* SUBMIT */
  profileForm.addEventListener('submit', e => {
    if (!isEditMode) { e.preventDefault(); return; }

    let valid = true;
    formInputs.forEach(i => {
      if (i.hasAttribute('required') && !i.value.trim()) {
        i.classList.add('invalid'); valid = false;
      } else { i.classList.remove('invalid'); }
    });

    if (!valid) { e.preventDefault(); return; }

    spinner.style.display  = 'block';
    saveIcon.style.display = 'none';
    submitBtn.disabled     = true;
    cancelEditBtn.disabled = true;
    // Soumission réelle vers Laravel
  });

  /* VALIDATION EN TEMPS RÉEL */
  formInputs.forEach(i => {
    if (i.hasAttribute('required')) {
      i.addEventListener('blur',  function() { if (!this.readOnly && !this.value.trim()) this.classList.add('invalid'); else this.classList.remove('invalid'); });
      i.addEventListener('input', function() { if (this.classList.contains('invalid') && this.value.trim()) this.classList.remove('invalid'); });
    }
  });

  /* AVERTISSEMENT FERMETURE */
  window.addEventListener('beforeunload', e => {
    if (isEditMode) {
      const changed = Array.from(formInputs).some(i => i.value !== originalValues[i.name]) || avatarPreview.src !== originalAvatarSrc;
      if (changed) { e.preventDefault(); e.returnValue = ''; }
    }
  });
})();
</script>