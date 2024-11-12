@props(['p', 'l', 'active'])
@php
    $activeColour = ($active ?? false) ? 'fill-[#5E93DA] dark:fill-[#5E93DA]' : 'fill-black dark:fill-white';
@endphp
<svg {{ $attributes->merge(['class' => $activeColour]) }} height="{{ $p }}"  width="{{ $l }}" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 viewBox="0 0 512 512"  xml:space="preserve">
<style type="text/css">

</style>
<g>
	<path class="st0" d="M498.472,223.88l-17.143-17.468L386.3,124.158c-8.627-7.452-19.646-11.558-31.024-11.558H157.146
		c-11.703,0-22.95,4.314-31.667,12.139L15.712,223.313C5.73,232.293,0,245.144,0,258.575v93.417C0,378.137,21.263,399.4,47.4,399.4
		h417.2c26.137,0,47.4-21.263,47.4-47.407v-94.945C512,244.577,507.196,232.798,498.472,223.88z M349.463,233.51l-1.293,5.433
		c-10.224,42.873-48.126,72.812-92.174,72.812c-44.047,0-81.943-29.939-92.166-72.812l-1.292-5.433h-20.096l-65.857,0.628
		l77.657-72.472c1.182-1.106,2.724-1.714,4.341-1.714h195.068c1.549,0,3.042,0.56,4.204,1.582l82.972,71.975H349.463z"/>
</g>
</svg>