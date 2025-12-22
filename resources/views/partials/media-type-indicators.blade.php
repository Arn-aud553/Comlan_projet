@php
    $types = $contenu->getTypesMediaDisponibles();
    $size = $size ?? '35px';
    $fontSize = $fontSize ?? '0.9rem';
@endphp

<div class="media-type-badges" style="display: flex; gap: 8px;">
    @foreach($types as $type)
        @php
            $iconData = match(strtolower($type)) {
                'video' => ['icon' => 'fa-video', 'label' => 'Vidéo', 'color' => '#ef4444'],
                'audio' => ['icon' => 'fa-headphones', 'label' => 'Audio', 'color' => '#3b82f6'],
                'document', 'livre', 'pdf' => ['icon' => 'fa-file-pdf', 'label' => 'Document', 'color' => '#10b981'],
                'image', 'photo' => ['icon' => 'fa-image', 'label' => 'Image', 'color' => '#f59e0b'],
                default => ['icon' => 'fa-file', 'label' => 'Fichier', 'color' => '#667eea']
            };
        @endphp
        <div class="media-type-icon" 
             title="{{ $iconData['label'] }}" 
             style="
                width: {{ $size }}; 
                height: {{ $size }}; 
                background: rgba(255, 255, 255, 0.9); 
                backdrop-filter: blur(10px); 
                border-radius: 50%; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                color: {{ $iconData['color'] }}; 
                font-size: {{ $fontSize }}; 
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
                transition: all 0.3s ease;
             ">
            <i class="fas {{ $iconData['icon'] }}"></i>
        </div>
    @endforeach
</div>
