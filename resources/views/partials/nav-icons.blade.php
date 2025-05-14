@php
$icons = [
    'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M12 3.172 2.929 12.243a1 1 0 0 0 1.414 1.414L5 13.001V20a1 1 0 0 0 1 1h4v-5h4v5h4a1 1 0 0 0 1-1v-6.999l.657.656a1 1 0 0 0 1.415-1.414L12 3.172Z"/></svg>',
    'shop' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M7 18c-1.1 0-2-.9-2-2V8H3V6h2V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2v2h-2v8c0 1.1-.9 2-2 2H7Zm0-2h10V8H7v8Zm2-10v2h6V6H9Z"/></svg>',
    'cart' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M7 18c-1.1 0-2-.9-2-2V8H3V6h2V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2v2h-2v8c0 1.1-.9 2-2 2H7Zm0-2h10V8H7v8Zm2-10v2h6V6H9Z"/></svg>',
    'profile' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/></svg>',
    'orders' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Zm0 16H5V5h14v14Zm-7-2h2v-2h-2v2Zm0-4h2v-4h-2v4Z"/></svg>',
    'events' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M17 3a1 1 0 0 1 1 1v1h1a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h1V4a1 1 0 1 1 2 0v1h8V4a1 1 0 0 1 1-1Zm3 6H4v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9Z"/></svg>',
    'admin' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/></svg>',
    'products' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="#fff" d="M21 16V8a2 2 0 0 0-2-2h-2V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-2h2a2 2 0 0 0 2-2Zm-8 4h-2v-2h2v2Zm6-4h-2v-2h2v2Zm-2-8h2v2h-2V4Zm-8 0h2v2H7V4Zm-2 8H3v-2h2v2Zm2 8v-2h2v2H7Zm8 0v-2h2v2h-2Zm2-8h2v2h-2v-2Z"/></svg>',
];
echo $icons[$icon] ?? '';
@endphp
