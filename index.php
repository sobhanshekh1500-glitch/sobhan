<?php
declare(strict_types=1);

// Security headers for the image-compression application.
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Frame-Options: SAMEORIGIN');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- SEO Tags -->
    <title>فشرده‌سازی عکس</title>
    <meta name="description" content="ابزار حرفه‌ای و کاملاً آفلاین فشرده‌ساز عکس. کاهش حجم تصاویر با حفظ کیفیت اصلی، پشتیبانی از فرمت‌های WebP، JPG و PNG. حذف اگزيف و واترمارک گذاری بدون آپلود در سرور.">
    <meta name="keywords" content="فشرده ساز عکس, کاهش حجم عکس, بهینه سازی تصویر, مبدل وب پ, فشرده سازی آفلاین, WebP, کاهش حجم بدون افت کیفیت, ابزار سئو عکس, تغییر سایز گروهی">
    <meta name="robots" content="index, follow">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
@font-face {
    font-family: 'IRANSansX';
    src: url('../fonts/IRANSansXVF.woff2') format('woff2');
    font-weight: 100 900;
    font-style: normal;
    font-display: swap; 
}

body {
    background-color: #09090b;
    font-family: 'IRANSansX', Tahoma, sans-serif !important;
}

.gama-compressor-container {
    background-color: #000; color: #f8fafc;
    border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 10px 50px rgba(0,0,0,0.8);
    padding: 24px; box-sizing: border-box; 
    width: 100%; margin: auto;
    display: flex; flex-direction: column; gap: 20px;
}
.gama-compressor-container * { box-sizing: border-box; }

.btn {
    background-color: #ec4899; color: white; border: none; padding: 10px 14px;
    border-radius: 12px; cursor: pointer; font-family: inherit; font-size: 0.9rem; font-weight: bold; transition: all 0.2s ease; text-align: center; display: inline-block;
}
.btn:hover { opacity: 0.92; transform: translateY(-1px); }
.btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }
.btn-upload { background-color: rgba(255, 255, 255, 0.08); border: 2px dashed rgba(255, 255, 255, 0.2); }
.btn-upload:hover { border-color: rgba(255, 255, 255, 0.4); background-color: rgba(255, 255, 255, 0.12); }
.btn-gradient { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4); }

input[type="file"] { display: none; }
select, input[type="text"], input[type="number"] {
    background-color: rgba(0, 0, 0, 0.45); color: white; border: 1px solid rgba(255, 255, 255, 0.12); 
    padding: 12px; border-radius: 10px; font-family: inherit; width: 100%; outline: none; font-size: 0.9rem; direction: ltr; transition: border-color 0.2s;
}
select:focus, input[type="text"]:focus, input[type="number"]:focus { border-color: #ec4899; }
.form-label { display: block; margin-bottom: 8px; font-size: 0.8rem; color: #94a3b8; text-align: right; }

input[type="range"] { -webkit-appearance: none; appearance: none; width: 100%; background: transparent; margin: 12px 0; cursor: pointer; }
input[type="range"]:focus { outline: none; }
input[type="range"]::-webkit-slider-runnable-track { width: 100%; height: 6px; background: rgba(255,255,255,0.15); border-radius: 3px; }
input[type="range"]::-webkit-slider-thumb { -webkit-appearance: none; height: 22px; width: 22px; border-radius: 50%; background: #ec4899; margin-top: -8px; box-shadow: 0 0 12px rgba(236,72,153,0.6); transition: transform 0.1s; }
input[type="range"]::-webkit-slider-thumb:hover { transform: scale(1.15); }
input[type="range"]::-moz-range-track { width: 100%; height: 6px; background: rgba(255,255,255,0.15); border-radius: 3px; }
input[type="range"]::-moz-range-thumb { height: 22px; width: 22px; border-radius: 50%; background: #ec4899; box-shadow: 0 0 12px rgba(236,72,153,0.6); border: none; transition: transform 0.1s; }
input[type="range"]::-moz-range-thumb:hover { transform: scale(1.15); }

input[type="color"] { -webkit-appearance: none; border: none; padding: 0; background: transparent; cursor: pointer; border-radius: 6px; overflow: hidden; width: 35px; height: 35px; }
input[type="color"]::-webkit-color-swatch-wrapper { padding: 0; }
input[type="color"]::-webkit-color-swatch { border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; }

.batch-settings-grid { display: flex; flex-direction: column; gap: 16px; background: rgba(0,0,0,0.3); padding: 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08); }
.batch-list-container { overflow-y: auto; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 12px; display: flex; flex-direction: column; gap: 10px; height: 100%; min-height: 480px; max-height: 650px; }
.batch-list-container::-webkit-scrollbar { width: 6px; }
.batch-list-container::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
.batch-list-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
.batch-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; transition: background 0.2s; }
.batch-item.done { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); }
.batch-thumb-wrapper { position: relative; width: 55px; height: 55px; flex-shrink: 0; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,0.12); }
.batch-thumb { width: 100%; height: 100%; object-fit: cover; }
.batch-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 5px; text-align: left; }
.batch-name { font-size: 0.85rem; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; direction: ltr; }
.batch-stats { font-size: 0.75rem; color: #94a3b8; display: flex; gap: 6px; align-items: center; flex-wrap: wrap;}
.stat-badge { background: rgba(0,0,0,0.5); padding: 4px 8px; border-radius: 6px; }
.stat-new { color: #10b981; font-weight: bold; }

.privacy-box { background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-right: 4px solid #3b82f6; border-radius: 12px; padding: 14px 18px; font-size: 0.82rem; color: #cbd5e1; line-height: 1.7; margin-top: auto; }

#compareImgContainer { cursor: grab; touch-action: none; }
#compareImgContainer:active { cursor: grabbing; }
#compareImg { will-change: transform; pointer-events: none; }

.font-preload { position: absolute; opacity: 0; pointer-events: none; user-select: none; }

    
/* ===== GAMA PRO | Premium Aqua / Black / Graphite Theme ===== */
:root {
  color-scheme: dark;
  --aqua: #35e0dc;
  --aqua-soft: #8af4ef;
  --graphite: #171d23;
  --panel: rgba(20, 27, 34, .88);
}
html {
  min-height: 100%;
  background: #080d12;
}
body {
  min-height: 100vh;
  color: #e8f1f4;
  background:
    radial-gradient(ellipse at 12% 8%, rgba(29, 205, 202, .20), transparent 34%),
    radial-gradient(ellipse at 88% 28%, rgba(91, 111, 124, .20), transparent 38%),
    radial-gradient(ellipse at 50% 100%, rgba(17, 116, 123, .13), transparent 42%),
    linear-gradient(135deg, #070b0f 0%, #111820 48%, #080d12 100%) !important;
  background-attachment: fixed !important;
}
.gama-compressor-container {
  position: relative;
  isolation: isolate;
  overflow: hidden;
  background: linear-gradient(145deg, rgba(24, 33, 41, .97), rgba(8, 13, 18, .97)) !important;
  border: 1px solid rgba(91, 230, 225, .25) !important;
  box-shadow: 0 24px 80px rgba(0,0,0,.58), 0 0 45px rgba(43, 210, 207, .08), inset 0 1px 0 rgba(255,255,255,.06) !important;
  backdrop-filter: blur(18px);
}
.gama-compressor-container::before {
  content: "";
  position: absolute;
  z-index: -1;
  width: 360px;
  height: 360px;
  top: -230px;
  right: -100px;
  border-radius: 50%;
  background: rgba(48, 224, 218, .12);
  filter: blur(35px);
  pointer-events: none;
}
.batch-settings-grid {
  background: linear-gradient(145deg, rgba(38, 49, 58, .78), rgba(13, 19, 25, .86)) !important;
  border: 1px solid rgba(148, 163, 184, .16) !important;
  box-shadow: inset 0 1px 0 rgba(255,255,255,.035);
}
.batch-list-container {
  background: rgba(8, 13, 18, .62) !important;
  border-color: rgba(111, 220, 218, .14) !important;
}
.batch-item {
  background: linear-gradient(110deg, rgba(36, 48, 57, .72), rgba(18, 25, 32, .78)) !important;
  border-color: rgba(148, 163, 184, .12) !important;
}
.batch-item:hover {
  border-color: rgba(53, 224, 220, .42) !important;
  background: rgba(39, 58, 65, .78) !important;
}
.btn {
  background: linear-gradient(135deg, #21c9c6, #168d99) !important;
  color: #041416 !important;
  border: 1px solid rgba(138, 244, 239, .35) !important;
  box-shadow: 0 7px 22px rgba(25, 190, 190, .16);
}
.btn:hover {
  filter: brightness(1.12);
  box-shadow: 0 9px 28px rgba(25, 210, 205, .24);
}
.btn-upload {
  color: #c9f8f5 !important;
  background: rgba(42, 199, 196, .055) !important;
  border: 1.5px dashed rgba(78, 220, 215, .42) !important;
  box-shadow: none !important;
}
.btn-upload:hover {
  background: rgba(42, 199, 196, .12) !important;
  border-color: var(--aqua) !important;
}
.btn-gradient {
  background: linear-gradient(120deg, #36e0d8, #8aaeb7, #d0e0e2) !important;
  color: #071316 !important;
  box-shadow: 0 7px 24px rgba(45, 207, 203, .2) !important;
}
select, input[type="text"], input[type="number"] {
  background: rgba(5, 11, 16, .72) !important;
  border-color: rgba(148, 177, 187, .2) !important;
}
select:focus, input[type="text"]:focus, input[type="number"]:focus {
  border-color: var(--aqua) !important;
  box-shadow: 0 0 0 3px rgba(53, 224, 220, .10);
}
input[type="range"]::-webkit-slider-thumb {
  background: var(--aqua) !important;
  box-shadow: 0 0 14px rgba(53, 224, 220, .5) !important;
}
input[type="range"]::-moz-range-thumb {
  background: var(--aqua) !important;
  box-shadow: 0 0 14px rgba(53, 224, 220, .5) !important;
}
.privacy-box {
  background: linear-gradient(110deg, rgba(36, 177, 179, .09), rgba(30, 41, 51, .5)) !important;
  border-color: rgba(65, 211, 207, .2) !important;
  border-right-color: var(--aqua) !important;
}
footer {
  background: linear-gradient(145deg, rgba(25, 34, 42, .96), rgba(8, 13, 18, .98)) !important;
  border-color: rgba(92, 220, 216, .18) !important;
  box-shadow: 0 18px 65px rgba(0,0,0,.5), 0 0 35px rgba(37, 190, 190, .06) !important;
}
#batchListTitle { color: #b9c9cf !important; }
#qualityDisplay { color: var(--aqua) !important; }
.gama-compressor-container h2 { color: #73deda !important; }
.gama-compressor-container a:hover { color: var(--aqua-soft) !important; }
footer h3 { color: #6de4df !important; }
footer h3 span { background: #35c9c5 !important; }
@media (max-width: 640px) {
  body { background-attachment: scroll !important; }
  .gama-compressor-container { border-radius: 20px; padding: 16px; }
}

    
/* Premium Aurora background theme */
:root {
  --bg-primary: #090d1b;
  --bg-secondary: #111a32;
  --accent-primary: #8b5cf6;
  --accent-secondary: #22d3ee;
  --accent-tertiary: #f472b6;
}
html, body {
  background:
    radial-gradient(ellipse at 12% 8%, rgba(139,92,246,.24), transparent 34%),
    radial-gradient(ellipse at 88% 18%, rgba(34,211,238,.19), transparent 32%),
    radial-gradient(ellipse at 75% 88%, rgba(244,114,182,.14), transparent 35%),
    linear-gradient(135deg, #080c19 0%, #111a32 48%, #0b1427 100%) !important;
  background-attachment: fixed !important;
}
body::before {
  background:
    radial-gradient(circle at 18% 22%, rgba(34,211,238,.11), transparent 26%),
    radial-gradient(circle at 82% 64%, rgba(139,92,246,.13), transparent 30%) !important;
  opacity: 1 !important;
}
header, footer, .container, .main-container, .app-container {
  background-color: transparent;
}
:where(.card, .panel, .section, .upload-area, .result-box, .tool-card) {
  background: linear-gradient(145deg, rgba(24,34,60,.88), rgba(12,19,36,.92)) !important;
  border-color: rgba(139, 164, 255, .20) !important;
  box-shadow: 0 16px 42px rgba(0,0,0,.24), inset 0 1px 0 rgba(255,255,255,.035) !important;
}
:where(button, .btn, input[type="button"], input[type="submit"]) {
  background-image: linear-gradient(115deg, #7357e8, #397ee8 52%, #17b8c8) !important;
  border-color: rgba(155,190,255,.3) !important;
}
:where(button:hover, .btn:hover, input[type="button"]:hover, input[type="submit"]:hover) {
  filter: brightness(1.12) saturate(1.12);
}
:where(h1, h2, h3, .section-title) {
  background: linear-gradient(90deg, #a78bfa, #67e8f9 55%, #f0abfc);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}
:where(input, select, textarea) {
  background-color: rgba(8,14,29,.78) !important;
  border-color: rgba(125,155,220,.28) !important;
}



/* ===== SUBHAN PREMIUM BLACK / ELECTRIC BLUE / GOLD THEME ===== */
:root {
  color-scheme: dark;
  --subhan-black: #03060c;
  --subhan-panel: rgba(5, 13, 25, .94);
  --subhan-blue: #08a9ff;
  --subhan-blue-soft: #63d5ff;
  --subhan-gold: #f7c84b;
  --subhan-gold-soft: #ffe59a;
}
html {
  background: #02050a !important;
  min-height: 100%;
}
body {
  min-height: 100vh !important;
  color: #edf6ff !important;
  background:
    radial-gradient(ellipse at 8% 8%, rgba(0, 132, 255, .26), transparent 31%),
    radial-gradient(ellipse at 92% 18%, rgba(255, 184, 35, .13), transparent 26%),
    radial-gradient(ellipse at 80% 78%, rgba(0, 91, 190, .20), transparent 33%),
    linear-gradient(145deg, #020409 0%, #071426 48%, #02050a 100%) !important;
  background-attachment: fixed !important;
  font-family: 'IRANSansX', Tahoma, sans-serif !important;
  position: relative;
}
body::before {
  content: "";
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  opacity: .52;
  background:
    radial-gradient(circle at 8% 16%, rgba(0, 174, 255, .26) 0 1px, transparent 2px),
    radial-gradient(circle at 91% 72%, rgba(255, 197, 65, .22) 0 1px, transparent 2px);
  background-size: 27px 27px, 34px 34px;
  mask-image: linear-gradient(to bottom, #000, transparent 88%);
}
body > * {
  position: relative;
  z-index: 1;
}
.gama-compressor-container {
  color: #f4f8ff !important;
  background:
    linear-gradient(135deg, rgba(10, 25, 45, .97), rgba(2, 6, 13, .98) 54%, rgba(5, 15, 29, .97)) !important;
  border: 1px solid rgba(27, 166, 255, .62) !important;
  border-radius: 30px !important;
  box-shadow:
    0 0 0 1px rgba(255, 201, 72, .18),
    0 0 24px rgba(0, 143, 255, .22),
    0 22px 70px rgba(0, 0, 0, .82),
    inset 0 1px 0 rgba(255, 255, 255, .08) !important;
  padding: clamp(16px, 3vw, 30px) !important;
  overflow: hidden;
  position: relative;
}
.gama-compressor-container::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: inherit;
  padding: 1px;
  background: linear-gradient(135deg, rgba(255, 207, 79, .9), transparent 20%, rgba(0, 164, 255, .75) 52%, transparent 75%, rgba(255, 196, 56, .75));
  -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  pointer-events: none;
}
.gama-compressor-container > div {
  position: relative;
  z-index: 1;
}
.gama-compressor-container h1 a {
  color: #f5f9ff !important;
  text-shadow: 0 0 18px rgba(0, 156, 255, .45);
}
.gama-compressor-container h1 a::first-letter {
  color: var(--subhan-gold);
}
.gama-compressor-container h2 {
  color: var(--subhan-gold-soft) !important;
}
.gama-compressor-container .border-b,
.gama-compressor-container .border-t {
  border-color: rgba(80, 166, 230, .24) !important;
}
.batch-settings-grid {
  background: linear-gradient(145deg, rgba(7, 20, 37, .92), rgba(2, 7, 15, .94)) !important;
  border: 1px solid rgba(0, 157, 255, .42) !important;
  border-radius: 22px !important;
  box-shadow: inset 0 0 25px rgba(0, 128, 255, .07), 0 8px 28px rgba(0, 0, 0, .34) !important;
}
#dropZone {
  color: #f4f8ff !important;
  background: linear-gradient(135deg, rgba(0, 93, 170, .18), rgba(1, 8, 18, .94), rgba(138, 94, 8, .12)) !important;
  border: 2px dashed rgba(0, 181, 255, .88) !important;
  border-radius: 20px !important;
  box-shadow: 0 0 18px rgba(0, 151, 255, .18), inset 0 0 22px rgba(0, 140, 255, .08) !important;
  min-height: 145px;
}
#dropZone svg {
  color: var(--subhan-blue-soft) !important;
  filter: drop-shadow(0 0 9px rgba(0, 170, 255, .75));
}
#dropZone:hover {
  border-color: var(--subhan-gold) !important;
  box-shadow: 0 0 25px rgba(0, 158, 255, .3), 0 0 16px rgba(247, 200, 75, .18) !important;
}
.form-label, .text-zinc-400, .text-slate-400 {
  color: #a9c0d7 !important;
}
#qualityDisplay, .text-pink-500, .text-pink-400, .text-fuchsia-500 {
  color: var(--subhan-gold) !important;
}
select, input[type="text"], input[type="number"], #wmPanel {
  color: #f4f8ff !important;
  background: rgba(1, 7, 15, .9) !important;
  border: 1px solid rgba(51, 157, 226, .4) !important;
  box-shadow: inset 0 1px 5px rgba(0, 0, 0, .45);
}
select:focus, input[type="text"]:focus, input[type="number"]:focus {
  border-color: var(--subhan-gold) !important;
  box-shadow: 0 0 0 3px rgba(247, 200, 75, .12) !important;
}
input[type="range"]::-webkit-slider-runnable-track {
  background: linear-gradient(90deg, #087bd2, #f2bd3e) !important;
}
input[type="range"]::-webkit-slider-thumb {
  background: linear-gradient(145deg, #fff0ae, #e9a91d) !important;
  box-shadow: 0 0 0 4px rgba(247, 200, 75, .15), 0 0 16px rgba(0, 164, 255, .55) !important;
}
input[type="range"]::-moz-range-track {
  background: linear-gradient(90deg, #087bd2, #f2bd3e) !important;
}
input[type="range"]::-moz-range-thumb {
  background: linear-gradient(145deg, #fff0ae, #e9a91d) !important;
  box-shadow: 0 0 0 4px rgba(247, 200, 75, .15), 0 0 16px rgba(0, 164, 255, .55) !important;
}
input[type="checkbox"] {
  accent-color: #e9b83f !important;
}
.btn {
  color: #fff !important;
  border: 1px solid rgba(247, 200, 75, .7) !important;
  background: linear-gradient(115deg, #064b91, #087fce 54%, #9a6a12) !important;
  box-shadow: 0 5px 18px rgba(0, 110, 210, .25), inset 0 1px 0 rgba(255, 255, 255, .18) !important;
  border-radius: 13px !important;
  transition: transform .2s ease, filter .2s ease, box-shadow .2s ease !important;
}
.btn:hover:not(:disabled) {
  filter: brightness(1.16) !important;
  transform: translateY(-2px);
  box-shadow: 0 7px 24px rgba(0, 145, 255, .35), 0 0 12px rgba(247, 200, 75, .16) !important;
}
.btn:disabled {
  opacity: .48 !important;
  filter: grayscale(.3);
}
.btn-upload {
  background: linear-gradient(135deg, rgba(0, 97, 180, .17), rgba(0, 0, 0, .25)) !important;
  border: 2px dashed rgba(0, 174, 255, .72) !important;
}
.btn-gradient {
  background: linear-gradient(110deg, #074f9b, #087ed0 48%, #b88720) !important;
}
#startBatchBtn {
  color: #ffe29a !important;
  background: linear-gradient(105deg, #073c73, #087bc7 48%, #9a6b12) !important;
  border: 1px solid #f5c44f !important;
  box-shadow: 0 0 18px rgba(0, 147, 255, .24), 0 0 14px rgba(247, 200, 75, .14) !important;
  font-weight: 800 !important;
}
#resetBatchBtn {
  background: rgba(10, 38, 65, .9) !important;
  color: #ffd879 !important;
  border: 1px solid rgba(247, 200, 75, .48) !important;
}
.batch-list-container {
  color: #edf6ff !important;
  background: linear-gradient(155deg, rgba(5, 17, 32, .94), rgba(2, 7, 14, .96)) !important;
  border: 1px solid rgba(0, 148, 255, .36) !important;
  border-radius: 20px !important;
  box-shadow: inset 0 0 25px rgba(0, 110, 220, .06) !important;
}
.batch-item {
  background: rgba(11, 29, 49, .82) !important;
  border: 1px solid rgba(59, 151, 213, .22) !important;
  border-radius: 13px !important;
}
.privacy-box {
  color: #b8c9d9 !important;
  background: rgba(5, 17, 30, .78) !important;
  border: 1px solid rgba(247, 200, 75, .24) !important;
  border-radius: 16px !important;
  padding: 15px !important;
}
.privacy-box strong {
  color: #ffe29a !important;
}
footer {
  color: #dcecff !important;
  background: linear-gradient(145deg, rgba(5, 15, 28, .97), rgba(2, 5, 11, .98)) !important;
  border: 1px solid rgba(0, 145, 255, .4) !important;
  box-shadow: 0 14px 50px rgba(0, 0, 0, .68), 0 0 20px rgba(0, 115, 220, .12) !important;
}
footer h3 {
  color: var(--subhan-blue-soft) !important;
}
footer h3 span {
  background: linear-gradient(90deg, var(--subhan-blue), var(--subhan-gold)) !important;
}
footer .text-zinc-400 {
  color: #bdcde0 !important;
}
footer .text-zinc-500 {
  color: #a9bfd3 !important;
}
footer .text-pink-500 {
  color: var(--subhan-gold) !important;
}
footer .bg-zinc-900 {
  background: rgba(8, 27, 48, .95) !important;
  border-color: rgba(247, 200, 75, .28) !important;
}
footer .font-mono {
  color: #f2d27a !important;
  background: rgba(4, 13, 24, .9) !important;
  border-color: rgba(0, 149, 255, .28) !important;
}
#compareModal {
  background: rgba(0, 3, 8, .97) !important;
}
#compareImgContainer {
  background: rgba(5, 17, 31, .9) !important;
  border-color: rgba(0, 157, 255, .5) !important;
}
#compareModal .text-pink-400 {
  color: var(--subhan-gold) !important;
}
@media (max-width: 640px) {
  body {
    padding: 8px !important;
  }
  .gama-compressor-container {
    border-radius: 23px !important;
    padding: 15px !important;
  }
  .batch-settings-grid {
    padding: 14px !important;
    gap: 14px !important;
  }
  footer {
    padding: 20px !important;
    border-radius: 22px !important;
  }
}



/* Signature edition badge */
footer .subhan-version-card {
  width: min(100%, 360px);
  margin: 22px auto 4px;
  padding: 17px 18px 15px;
  position: relative;
  isolation: isolate;
  overflow: visible;
  text-align: center;
  border-radius: 18px;
  border: 1px solid rgba(36, 169, 255, .72);
  background:
    radial-gradient(ellipse at 50% 0%, rgba(12, 135, 255, .20), transparent 58%),
    linear-gradient(145deg, rgba(8, 24, 43, .98), rgba(2, 7, 15, .99) 68%);
  box-shadow:
    0 0 0 1px rgba(245, 195, 69, .22),
    0 0 22px rgba(0, 145, 255, .16),
    inset 0 1px 0 rgba(255, 255, 255, .10);
}
footer .subhan-version-crown {
  position: absolute;
  top: -17px;
  left: 50%;
  transform: translateX(-50%);
  width: 36px;
  height: 30px;
  display: grid;
  place-items: center;
  color: #ffe39a;
  font-size: 28px;
  line-height: 1;
  text-shadow: 0 0 8px rgba(255, 191, 48, .85), 0 0 18px rgba(255, 174, 0, .42);
  background: #071323;
  border-radius: 50%;
}
footer .subhan-version-main {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  gap: 12px;
  padding: 3px 0 12px;
}
footer .subhan-brand {
  color: #42c5ff;
  font-size: 15px;
  font-weight: 900;
  letter-spacing: 2.5px;
  text-shadow: 0 0 12px rgba(0, 162, 255, .4);
}
footer .subhan-version-divider {
  height: 19px;
  width: 1px;
  background: linear-gradient(transparent, #f5c34b, transparent);
}
footer .subhan-version-number {
  color: #ffdc83;
  font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, monospace;
  letter-spacing: 1px;
}
footer .subhan-version-tech {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding-top: 11px;
  border-top: 1px solid rgba(245, 195, 69, .36);
  color: #e8d49e;
  font: 700 10px/1.4 ui-monospace, SFMono-Regular, Menlo, monospace;
  letter-spacing: 1.1px;
}
footer .subhan-version-tech svg {
  width: 17px;
  height: 17px;
  fill: none;
  stroke: #f4c34c;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
  filter: drop-shadow(0 0 5px rgba(245, 195, 69, .55));
}
footer .subhan-version-tech i {
  display: block;
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background: #16aaff;
  box-shadow: 0 0 7px #16aaff;
}
footer .subhan-version-shine {
  position: absolute;
  z-index: -1;
  inset: -1px;
  border-radius: inherit;
  pointer-events: none;
  background: linear-gradient(115deg, transparent 15%, rgba(40, 174, 255, .11) 35%, transparent 53%, rgba(255, 204, 83, .08) 78%, transparent);
}
@media (max-width: 380px) {
  footer .subhan-version-card { padding: 16px 10px 13px; }
  footer .subhan-version-main { gap: 8px; }
  footer .subhan-version-tech { gap: 6px; font-size: 9px; letter-spacing: .7px; }
}


/* ===== SUBHAN UI FONT: VAZIRMATN ===== */
html, body {
  font-family: 'Vazirmatn', Tahoma, sans-serif !important;
}
body :where(*):not(.font-mono):not(code):not(pre) {
  font-family: inherit !important;
}
button, input, select, textarea, option {
  font-family: 'Vazirmatn', Tahoma, sans-serif !important;
}
.gama-compressor-container,
.gama-compressor-container button,
.gama-compressor-container input,
.gama-compressor-container select,
.gama-compressor-container label,
footer,
footer :where(*):not(.font-mono):not(code):not(pre) {
  font-family: 'Vazirmatn', Tahoma, sans-serif !important;
}

</style>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-Variable-font-face.css" rel="stylesheet">

</head>
<body class="flex flex-col items-center w-full min-h-screen p-2 md:p-5"> 

<div class="font-preload">
    <span style="font-family: 'IRANSansX'">.</span>
</div>

<!-- Main Wrapper -->
<div class="w-full max-w-[1100px] flex flex-col gap-8 my-auto pb-8"> 

    <!-- App Container -->
    <main class="gama-compressor-container w-full !m-0 !mt-4 md:!mt-0">
        <div class="flex flex-col md:flex-row gap-8 h-full">
            
            <!-- Right Column: Settings -->
            <div class="w-full md:w-5/12 flex flex-col gap-4">
                
                <!-- Header & Reset -->
                <div class="flex flex-col sm:flex-row justify-between items-center sm:items-start gap-4 border-b border-white/10 pb-4 text-center sm:text-right">
                    <div class="w-full sm:w-auto">
                        <h1 class="m-0 text-[1.3rem] leading-tight">
                            <a href="/" title="صفحه اصلی فشرده‌سازی عکس" class="text-slate-50 hover:text-pink-400 transition-colors duration-300" style="text-decoration: none;">فشرده‌سازی عکس</a>
                        </h1>
                        <h2 class="text-[0.8rem] text-purple-400 mt-1 font-normal">تولید تصاویر سئو شده + حذف EXIF</h2>
                    </div>
                    <div class="w-full sm:w-auto">
                        <button id="resetBatchBtn" class="btn w-full sm:w-auto px-4 py-2 text-[0.85rem]" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">↻ ریست کامل</button>
                    </div>
                </div>

                <div class="batch-settings-grid">
                    <label id="dropZone" class="btn btn-upload flex flex-col justify-center items-center py-6 px-5 gap-3 transition-all w-full">
                        <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <span class="text-[0.95rem]">انتخاب عکس‌ها یا Drag & Drop</span>
                        <input type="file" id="batchFilesInput" accept="image/*" multiple>
                    </label>

                    <!-- Quality Slider -->
                    <div>
                        <label class="form-label flex justify-between">
                            <span>کیفیت تصویر:</span>
                            <span id="qualityDisplay" class="text-pink-500 font-bold" dir="rtl">۶ (بهینه برای وب)</span>
                        </label>
                        <input type="range" id="batchQuality" min="1" max="10" value="6">
                    </div>

                    <!-- Dimension & Format -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-1">
                        <div class="w-full">
                            <label class="form-label">حداکثر عرض (پیکسل):</label>
                            <input type="number" id="batchMaxWidth" value="1200" placeholder="خالی = سایز اصلی" class="!text-center">
                        </div>
                        <div class="w-full">
                            <label class="form-label">فرمت نهایی:</label>
                            <select id="batchFormat" class="!text-center">
                                <option value="image/webp" selected>WEBP (گوگل)</option>
                                <option value="image/jpeg">JPG</option>
                                <option value="image/png">PNG</option>
                            </select>
                        </div>
                    </div>

                    <!-- Output Prefix -->
                    <div>
                        <label class="form-label">نام فایل خروجی (اختیاری):</label>
                        <input type="text" id="batchPrefix" placeholder="مثال: product_image" class="!text-center">
                    </div>

                    <!-- Watermark Settings -->
                    <div class="border-t border-dashed border-white/15 pt-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-pink-400 font-bold mb-3">
                            <input type="checkbox" id="wmEnable" class="w-4 h-4 accent-pink-500 rounded"> درج واترمارک روی عکس (اختیاری)
                        </label>
                        
                        <div id="wmPanel" style="display: none; flex-direction: column; gap: 12px; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                            <div class="flex flex-col sm:flex-row gap-2">
                                <select id="wmType" class="flex-1 !py-2 !text-xs !bg-zinc-800 w-full text-center">
                                    <option value="text">متن (Text)</option>
                                    <option value="image">تصویر (Logo)</option>
                                </select>
                                <select id="wmPos" class="flex-1 !py-2 !text-xs !bg-zinc-800 w-full text-center">
                                    <option value="br">پایین راست</option>
                                    <option value="bl">پایین چپ</option>
                                    <option value="tr">بالا راست</option>
                                    <option value="tl">بالا چپ</option>
                                    <option value="center">وسط</option>
                                    <option value="tile">کاشی‌کاری (تکرار)</option>
                                </select>
                            </div>
                            
                            <div id="wmTileSettings" class="flex items-center gap-3" style="display: none;">
                                <label class="text-xs text-zinc-400 whitespace-nowrap">فاصله تکرار (تراکم):</label>
                                <input type="range" id="wmTileSpacing" min="0.5" max="4" step="0.25" value="1.5">
                            </div>
                            
                            <div id="wmTextSettings" class="flex flex-col gap-3">
                                <input type="text" id="wmText" placeholder="متن واترمارک (مثال: @MyPage)" class="!py-2 !text-sm !bg-zinc-800 w-full text-center">
                                
                                <div class="flex gap-2 items-center w-full flex-wrap sm:flex-nowrap">
                                    <select id="wmFont" class="flex-1 !py-2 !text-xs !bg-zinc-800 w-full text-center">
                                        <option value="Vazirmatn" selected>وزیرمتن</option>
                                        <option value="Sahel">فونت ساحل</option>
                                        <option value="Arial">Arial</option>
                                        <option value="Impact">Impact</option>
                                        <option value="Times New Roman">Times New Roman</option>
                                    </select>
                                    <input type="color" id="wmColor" value="#ffffff" title="رنگ متن" class="shrink-0">
                                </div>

                                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                                    <label class="text-xs text-zinc-400 whitespace-nowrap">شفافیت:</label>
                                    <input type="range" id="wmOpacity" min="0.1" max="1" step="0.1" value="0.7">
                                    <label class="text-xs text-zinc-400 whitespace-nowrap">سایز:</label>
                                    <input type="range" id="wmSize" min="2" max="20" step="1" value="5">
                                </div>
                            </div>
                            
                            <div id="wmImageSettings" class="flex flex-col gap-3" style="display: none;">
                                <label class="btn btn-upload !py-2 text-sm w-full">
                                    انتخاب لوگو (PNG شفاف)
                                    <input type="file" id="wmImageInput" accept="image/png, image/webp">
                                </label>
                                <span id="wmImageName" class="text-xs text-zinc-400 text-center">فایلی انتخاب نشده</span>
                                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                                    <label class="text-xs text-zinc-400 whitespace-nowrap">شفافیت:</label>
                                    <input type="range" id="wmImgOpacity" min="0.1" max="1" step="0.1" value="0.8">
                                    <label class="text-xs text-zinc-400 whitespace-nowrap">سایز لوگو:</label>
                                    <input type="range" id="wmImgScale" min="5" max="100" step="5" value="20">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Button -->
                <button id="startBatchBtn" class="btn py-3.5 text-[1.05rem] w-full mt-1" style="background: rgba(168, 85, 247, 0.15); border: 1px solid #a855f7; color: #d8b4fe;" disabled>⚙️ شروع پردازش</button>
                
                <div class="privacy-box mt-auto">
                    <div style="display: flex; align-items: center; gap: 8px; color: #60a5fa; font-weight: bold; font-size: 0.9rem; margin-bottom: 8px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        امنیت و کارکرد برنامه:
                    </div>
                    <ul style="margin: 0; padding-right: 20px; list-style-type: disc;">
                        <li><strong style="color: #fff;">۱۰۰٪ آفلاین و محلی:</strong> عکس‌های شما در هیچ سروری آپلود نمی‌شوند.</li>
                        <li><strong style="color: #fff;">حذف متادیتا (EXIF):</strong> ردپای نرم‌افزارهای کپی‌رایت پاک می‌شود.</li>
                        <li><strong style="color: #fff;">الگوریتم جدید:</strong> شفافیت و وضوح تصاویر در تغییر ابعاد حفظ می‌شود.</li>
                    </ul>
                </div>
            </div>

            <!-- Left Column: File List -->
            <div class="w-full md:w-7/12 flex flex-col">
                <div class="flex justify-between items-center mb-3 pt-1">
                    <span id="batchListTitle" class="text-[1.05rem] font-bold text-slate-400">لیست تصاویر (۰)</span>
                    <button id="downloadAllBatchBtn" class="btn btn-gradient px-5 py-2 hidden">⬇️ دانلود همگی</button>
                </div>
                
                <div id="batchListContainer" class="batch-list-container">
                    <div class="text-center text-slate-500 text-[0.95rem] m-auto py-10">
                        فایلی انتخاب نشده است...
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="w-full bg-[#050507] border border-white/10 rounded-[24px] p-8 md:p-10 shadow-[0_15px_60px_rgba(0,0,0,0.8)] mt-2">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            
            <!-- About Info -->
            <div class="md:col-span-7">
                <h3 class="text-fuchsia-500 font-bold text-xl mb-4 relative inline-block">
                    درباره ابزار فشرده‌سازی عکس
                    <span class="absolute -bottom-2 right-0 w-1/2 h-[3px] bg-fuchsia-500 rounded-full"></span>
                </h3>
                <p class="text-zinc-400 text-sm leading-8 mt-6 text-justify">
                    این سامانه یک ابزار پیشرفته و کاملاً سمت‌کاربر (Client-Side) است که با هدف بهینه‌سازی تصاویر برای سئو و کاهش حجم فایل‌ها بدون افت کیفیت بصری توسعه یافته است. تمامی فرآیندهای تغییر ابعاد، درج واترمارک و تبدیل فرمت به وب‌پ (WebP) منحصراً در مرورگر شما انجام شده و هیچ عکسی به سرورهای ما منتقل نمی‌شود؛ بنابراین حریم خصوصی شما به صورت کامل تضمین می‌گردد.
                </p>
                
            </div>

        </div>

        <!-- Copyright & Meta -->
        <div class="mt-10 pt-6 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3 text-xs text-zinc-500">
                <div class="w-8 h-8 rounded-lg bg-zinc-900 border border-white/5 flex items-center justify-center text-pink-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span>ساخته‌شده با عشق و خلاقیت توسط سبحان ✨ | فشرده‌سازی عکس، ساده، سریع و امن.</span>
            </div>
            
            <div class="subhan-version-card" aria-label="اطلاعات نسخه و هسته برنامه">
                <div class="subhan-version-crown" aria-hidden="true">♛</div>
                <div class="subhan-version-main">
                    <span class="subhan-brand">SUBHAN</span>
                    <span class="subhan-version-divider"></span>
                    <span class="subhan-version-number" dir="ltr">VERSION 1.2.0</span>
                </div>
                <div class="subhan-version-tech" dir="ltr">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.8 19 5.6v5.1c0 4.7-2.9 8.3-7 10.5-4.1-2.2-7-5.8-7-10.5V5.6L12 2.8Z"/>
                        <path d="m8.8 12.1 2.1 2.1 4.4-4.5"/>
                    </svg>
                    <span>SECURE</span><i></i><span>OFFLINE CORE</span>
                </div>
                <div class="subhan-version-shine" aria-hidden="true"></div>
            </div>
        </div>
    </footer>
</div>

<!-- Comparison Modal -->
<div id="compareModal" class="fixed inset-0 bg-black/95 z-50 hidden flex-col items-center justify-center">
    <div id="compareModalBg" class="absolute inset-0 z-0 cursor-pointer"></div>
    <div class="absolute top-4 right-4 text-zinc-400 hover:text-white cursor-pointer transition text-2xl font-bold z-20 bg-black/50 w-10 h-10 flex items-center justify-center rounded-full" onclick="closeCompare()" title="بستن">✖</div>
    
    <div class="flex gap-4 mb-4 z-20 pointer-events-auto mt-16 md:mt-4">
        <button id="btnViewOrig" class="btn bg-zinc-700 shadow-[0_0_15px_rgba(0,0,0,0.5)]" onclick="setShowOriginal(true)">اصلی (► راست)</button>
        <button id="btnViewComp" class="btn bg-pink-600 shadow-[0_0_15px_rgba(236,72,153,0.5)]" onclick="setShowOriginal(false)">فشرده‌شده (◄ چپ)</button>
    </div>
    
    <div id="compareImgContainer" class="relative w-full max-w-[95vw] md:max-w-[85vw] h-[65vh] md:h-[75vh] flex justify-center items-center overflow-hidden z-10 rounded-xl bg-zinc-900/30 border border-white/5">
        <img id="compareImg" src="" class="max-w-full max-h-full object-contain" style="transform: translate(0px, 0px) scale(1);" draggable="false">
        <div id="compareLabel" class="absolute top-4 left-4 bg-zinc-700 text-white px-3 py-1 rounded-md text-sm font-bold shadow-lg pointer-events-none">نسخه اصلی</div>
    </div>
    
    <div class="text-zinc-400 text-sm mt-6 z-20 text-center bg-black/50 px-4 py-2 rounded-lg pointer-events-none">
        برای تغییر عکس کلیدهای ⬅️ و ➡️ را فشار دهید.<br>
        <span class="text-pink-400">🔍 زوم با اسکرول ماوس یا لمس دو انگشتی (Pinch) | جابجایی با کشیدن (Drag)</span>
    </div>
</div>

<script>
// Gama Compressor - Fast & Secure Core
(function(){
    var _0x1a2b = "JTI4ZnVuY3Rpb24lMjAlMjglMjklMjAlN0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHJlc2V0QmF0Y2hCdG4lMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3Jlc2V0QmF0Y2hCdG4lMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMGJhdGNoRmlsZXNJbnB1dCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YmF0Y2hGaWxlc0lucHV0JTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjBkcm9wWm9uZSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3ZHJvcFpvbmUlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMGJhdGNoTGlzdENvbnRhaW5lciUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YmF0Y2hMaXN0Q29udGFpbmVyJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjBiYXRjaExpc3RUaXRsZSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YmF0Y2hMaXN0VGl0bGUlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHN0YXJ0QmF0Y2hCdG4lMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3N0YXJ0QmF0Y2hCdG4lMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMGRvd25sb2FkQWxsQmF0Y2hCdG4lMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2Rvd25sb2FkQWxsQmF0Y2hCdG4lMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMGJhdGNoUXVhbGl0eSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YmF0Y2hRdWFsaXR5JTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjBxdWFsaXR5RGlzcGxheSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3cXVhbGl0eURpc3BsYXklMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMGJhdGNoRm9ybWF0JTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglMjdiYXRjaEZvcm1hdCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwYmF0Y2hNYXhXaWR0aCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YmF0Y2hNYXhXaWR0aCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwYmF0Y2hQcmVmaXglMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2JhdGNoUHJlZml4JTI3JTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bUVuYWJsZSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21FbmFibGUlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHdtUGFuZWwlMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtUGFuZWwlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHdtVHlwZSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21UeXBlJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bVBvcyUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21Qb3MlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHdtVGlsZVNldHRpbmdzJTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglMjd3bVRpbGVTZXR0aW5ncyUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwd21UaWxlU3BhY2luZyUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21UaWxlU3BhY2luZyUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwd21UZXh0U2V0dGluZ3MlMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtVGV4dFNldHRpbmdzJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bUltYWdlU2V0dGluZ3MlMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtSW1hZ2VTZXR0aW5ncyUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwd21UZXh0JTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglMjd3bVRleHQlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHdtRm9udCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21Gb250JTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bUNvbG9yJTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglMjd3bUNvbG9yJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bU9wYWNpdHklMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtT3BhY2l0eSUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwd21TaXplJTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglMjd3bVNpemUlMjclMjklM0IlMEElMjAlMjAlMjAlMjBjb25zdCUyMHdtSW1hZ2VJbnB1dCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21JbWFnZUlucHV0JTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwY29uc3QlMjB3bUltZ09wYWNpdHklMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtSW1nT3BhY2l0eSUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwd21JbWdTY2FsZSUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3d21JbWdTY2FsZSUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGxldCUyMHdtSW1hZ2VPYmolMjAlM0QlMjBudWxsJTNCJTBBJTBBJTIwJTIwJTIwJTIwbGV0JTIwYmF0Y2hGaWxlcyUyMCUzRCUyMCU1QiU1RCUzQiUwQSUyMCUyMCUyMCUyMGxldCUyMGJhdGNoVXJscyUyMCUzRCUyMCU1QiU1RCUzQiUwQSUyMCUyMCUyMCUyMGxldCUyMHByb2Nlc3NlZFVybHMlMjAlM0QlMjAlNUIlNUQlM0IlMEElMEElMjAlMjAlMjAlMjBsZXQlMjBjdXJyZW50Q29tcGFyZUluZGV4JTIwJTNEJTIwLTElM0IlMEElMjAlMjAlMjAlMjBsZXQlMjBzaG93aW5nT3JpZ2luYWwlMjAlM0QlMjBmYWxzZSUzQiUwQSUyMCUyMCUyMCUyMGxldCUyMGltZ1NjYWxlJTIwJTNEJTIwMSUyQyUyMHBhblglMjAlM0QlMjAwJTJDJTIwcGFuWSUyMCUzRCUyMDAlMkMlMjBpc0RyYWdnaW5nSW1nJTIwJTNEJTIwZmFsc2UlMkMlMjBzdGFydERyYWdYJTIwJTNEJTIwMCUyQyUyMHN0YXJ0RHJhZ1klMjAlM0QlMjAwJTNCJTBBJTIwJTIwJTIwJTIwbGV0JTIwaXNQaW5jaGluZyUyMCUzRCUyMGZhbHNlJTJDJTIwcGluY2hTdGFydERpc3QlMjAlM0QlMjAwJTJDJTIwcGluY2hTdGFydFNjYWxlJTIwJTNEJTIwMSUzQiUwQSUyMCUyMCUyMCUyMCUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwY29tcENvbnRhaW5lciUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3Y29tcGFyZUltZ0NvbnRhaW5lciUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwY29tcEltZyUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3Y29tcGFyZUltZyUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMGNvbnN0JTIwbW9kYWxCZyUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3Y29tcGFyZU1vZGFsQmclMjclMjklM0IlMEElMEElMjAlMjAlMjAlMjAvLyUyMENhbGlicmF0ZWQlMjBxdWFsaXR5JTIwbGV2ZWxzJTIwZm9yJTIwb3V0cHV0JTBBJTIwJTIwJTIwJTIwY29uc3QlMjBxdWFsaXR5TGV2ZWxzJTIwJTNEJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwMSUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuNDAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUIxJTIwJTI4JUQ4JUFEJUQ4JUFDJUQ5JTg1JTIwJUQ4JUFFJURCJThDJUQ5JTg0JURCJThDJTIwJURBJUE5JUQ5JTg1JTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwMiUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuNTAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUIyJTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwMyUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuNjAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUIzJTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwNCUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuNzAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI0JTIwJTI4JUQ5JTg1JUQ4JUFBJUQ5JTg4JUQ4JUIzJUQ4JUI3JTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwNSUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuNzUlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI1JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwNiUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuODIlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI2JTIwJTI4JUQ4JUE4JUQ5JTg3JURCJThDJUQ5JTg2JUQ5JTg3JTIwJUQ4JUE4JUQ4JUIxJUQ4JUE3JURCJThDJTIwJUQ5JTg4JUQ4JUE4JTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwNyUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuODYlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI3JTIwJTI4JUQ5JTg4JUQ4JUI2JUQ5JTg4JUQ4JUFEJTIwJUQ4JUE4JUQ4JUE3JUQ5JTg0JUQ4JUE3JTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwOCUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuOTAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI4JTIwJTI4JUQ4JUI5JUQ4JUE3JUQ5JTg0JURCJThDJTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwOSUzQSUyMCU3QiUyMHZhbCUzQSUyMDAuOTQlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUI5JTIwJTI4JUQ4JUE4JUQ4JUFGJUQ5JTg4JUQ5JTg2JTIwJUQ4JUE3JUQ5JTgxJUQ4JUFBJTIwJUQ5JTg1JUQ4JUFEJUQ4JUIzJUQ5JTg4JUQ4JUIzJTI5JTI3JTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwMTAlM0ElMjAlN0IlMjB2YWwlM0ElMjAxLjAlMkMlMjB0ZXh0JTNBJTIwJTI3JURCJUIxJURCJUIwJTIwJTI4JUQ4JUFEJUQ4JUFGJUQ4JUE3JURBJUE5JUQ4JUFCJUQ4JUIxJTIwJURBJUE5JURCJThDJUQ5JTgxJURCJThDJUQ4JUFBJTI5JTI3JTIwJTdEJTIwJTBBJTIwJTIwJTIwJTIwJTdEJTNCJTBBJTBBJTIwJTIwJTIwJTIwbGV0JTIwc2xpZGVyVGltZW91dCUzQiUwQSUyMCUyMCUyMCUyMGJhdGNoUXVhbGl0eS5hZGRFdmVudExpc3RlbmVyJTI4JTI3aW5wdXQlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwcXVhbGl0eURpc3BsYXkudGV4dENvbnRlbnQlMjAlM0QlMjBxdWFsaXR5TGV2ZWxzJTVCZS50YXJnZXQudmFsdWUlNUQudGV4dCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNsZWFyVGltZW91dCUyOHNsaWRlclRpbWVvdXQlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzbGlkZXJUaW1lb3V0JTIwJTNEJTIwc2V0VGltZW91dCUyOGNoZWNrU2V0dGluZ3NDaGFuZ2VkJTJDJTIwMTAwJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTdEJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTBBJTIwJTIwJTIwJTIwYmF0Y2hGb3JtYXQuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2NoYW5nZSUyNyUyQyUyMGNoZWNrU2V0dGluZ3NDaGFuZ2VkJTI5JTNCJTBBJTIwJTIwJTIwJTIwYmF0Y2hNYXhXaWR0aC5hZGRFdmVudExpc3RlbmVyJTI4JTI3aW5wdXQlMjclMkMlMjBjaGVja1NldHRpbmdzQ2hhbmdlZCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMHdtRW5hYmxlLmFkZEV2ZW50TGlzdGVuZXIlMjglMjdjaGFuZ2UlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTIwd21QYW5lbC5zdHlsZS5kaXNwbGF5JTIwJTNEJTIwZS50YXJnZXQuY2hlY2tlZCUyMCUzRiUyMCUyN2ZsZXglMjclMjAlM0ElMjAlMjdub25lJTI3JTNCJTIwY2hlY2tTZXR0aW5nc0NoYW5nZWQlMjglMjklM0IlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjB3bVR5cGUuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2NoYW5nZSUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGlzVGV4dCUyMCUzRCUyMGUudGFyZ2V0LnZhbHVlJTIwJTNEJTNEJTNEJTIwJTI3dGV4dCUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHdtVGV4dFNldHRpbmdzLnN0eWxlLmRpc3BsYXklMjAlM0QlMjBpc1RleHQlMjAlM0YlMjAlMjdmbGV4JTI3JTIwJTNBJTIwJTI3bm9uZSUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHdtSW1hZ2VTZXR0aW5ncy5zdHlsZS5kaXNwbGF5JTIwJTNEJTIwaXNUZXh0JTIwJTNGJTIwJTI3bm9uZSUyNyUyMCUzQSUyMCUyN2ZsZXglMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjaGVja1NldHRpbmdzQ2hhbmdlZCUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUyMCUyMCUyMCUyMHdtUG9zLmFkZEV2ZW50TGlzdGVuZXIlMjglMjdjaGFuZ2UlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTIwd21UaWxlU2V0dGluZ3Muc3R5bGUuZGlzcGxheSUyMCUzRCUyMGUudGFyZ2V0LnZhbHVlJTIwJTNEJTNEJTNEJTIwJTI3dGlsZSUyNyUyMCUzRiUyMCUyN2ZsZXglMjclMjAlM0ElMjAlMjdub25lJTI3JTNCJTIwY2hlY2tTZXR0aW5nc0NoYW5nZWQlMjglMjklM0IlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjB3bUltYWdlSW5wdXQuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2NoYW5nZSUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGZpbGUlMjAlM0QlMjBlLnRhcmdldC5maWxlcyU1QjAlNUQlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOCUyMWZpbGUlMjklMjByZXR1cm4lM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN3dtSW1hZ2VOYW1lJTI3JTI5LnRleHRDb250ZW50JTIwJTNEJTIwZmlsZS5uYW1lJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjB1cmwlMjAlM0QlMjBVUkwuY3JlYXRlT2JqZWN0VVJMJTI4ZmlsZSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwaW1nJTIwJTNEJTIwbmV3JTIwSW1hZ2UlMjglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpbWcub25sb2FkJTIwJTNEJTIwJTI4JTI5JTIwJTNEJTNFJTIwJTdCJTIwd21JbWFnZU9iaiUyMCUzRCUyMGltZyUzQiUyMGNoZWNrU2V0dGluZ3NDaGFuZ2VkJTI4JTI5JTNCJTIwJTdEJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaW1nLnNyYyUyMCUzRCUyMHVybCUzQiUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUyMCUyMCUyMCUyMCU1QndtVGV4dCUyQyUyMHdtRm9udCUyQyUyMHdtQ29sb3IlMkMlMjB3bU9wYWNpdHklMkMlMjB3bVNpemUlMkMlMjB3bUltZ09wYWNpdHklMkMlMjB3bUltZ1NjYWxlJTJDJTIwd21Qb3MlMkMlMjB3bVRpbGVTcGFjaW5nJTVELmZvckVhY2glMjhlbCUyMCUzRCUzRSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGVsLmFkZEV2ZW50TGlzdGVuZXIlMjglMjdpbnB1dCUyNyUyQyUyMGNoZWNrU2V0dGluZ3NDaGFuZ2VkJTI5JTNCJTIwZWwuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2NoYW5nZSUyNyUyQyUyMGNoZWNrU2V0dGluZ3NDaGFuZ2VkJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTdEJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwZnVuY3Rpb24lMjBjaGVja1NldHRpbmdzQ2hhbmdlZCUyOCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4YmF0Y2hGaWxlcy5sZW5ndGglMjAlM0UlMjAwJTIwJTI2JTI2JTIwcHJvY2Vzc2VkVXJscy5zb21lJTI4dXJsJTIwJTNEJTNFJTIwdXJsJTIwJTIxJTNEJTNEJTIwbnVsbCUyOSUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHN0YXJ0QmF0Y2hCdG4uaW5uZXJIVE1MJTIwJTNEJTIwJTI3JUYwJTlGJTk0JTg0JTIwJUQ4JUE3JUQ4JUI5JUQ5JTg1JUQ4JUE3JUQ5JTg0JTIwJUQ5JTg1JUQ4JUFDJUQ4JUFGJUQ4JUFGJTIwJUQ4JUFBJUQ5JTg2JUQ4JUI4JURCJThDJUQ5JTg1JUQ4JUE3JUQ4JUFBJTIwJUQ4JUFDJUQ4JUFGJURCJThDJUQ4JUFGJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5iYWNrZ3JvdW5kJTIwJTNEJTIwJTI3JTIzM2I4MmY2JTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5ib3JkZXJDb2xvciUyMCUzRCUyMCUyNyUyMzI1NjNlYiUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHN0YXJ0QmF0Y2hCdG4uc3R5bGUuY29sb3IlMjAlM0QlMjAlMjclMjNmZmZmZmYlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlN0QlMEElMEElMjAlMjAlMjAlMjBkcm9wWm9uZS5hZGRFdmVudExpc3RlbmVyJTI4JTI3ZHJhZ292ZXIlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTIwZS5wcmV2ZW50RGVmYXVsdCUyOCUyOSUzQiUyMGRyb3Bab25lLnN0eWxlLmJvcmRlckNvbG9yJTIwJTNEJTIwJTI3JTIzZWM0ODk5JTI3JTNCJTIwZHJvcFpvbmUuc3R5bGUuYmFja2dyb3VuZENvbG9yJTIwJTNEJTIwJTI3cmdiYSUyODIzNiUyQyUyMDcyJTJDJTIwMTUzJTJDJTIwMC4xJTI5JTI3JTNCJTIwJTdEJTI5JTNCJTBBJTIwJTIwJTIwJTIwZHJvcFpvbmUuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2RyYWdsZWF2ZSUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMjBlLnByZXZlbnREZWZhdWx0JTI4JTI5JTNCJTIwZHJvcFpvbmUuc3R5bGUuYm9yZGVyQ29sb3IlMjAlM0QlMjAlMjdyZ2JhJTI4MjU1JTJDJTIwMjU1JTJDJTIwMjU1JTJDJTIwMC4yJTI5JTI3JTNCJTIwZHJvcFpvbmUuc3R5bGUuYmFja2dyb3VuZENvbG9yJTIwJTNEJTIwJTI3cmdiYSUyODI1NSUyQyUyMDI1NSUyQyUyMDI1NSUyQyUyMDAuMDglMjklMjclM0IlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjBkcm9wWm9uZS5hZGRFdmVudExpc3RlbmVyJTI4JTI3ZHJvcCUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBlLnByZXZlbnREZWZhdWx0JTI4JTI5JTNCJTIwZHJvcFpvbmUuc3R5bGUuYm9yZGVyQ29sb3IlMjAlM0QlMjAlMjdyZ2JhJTI4MjU1JTJDJTIwMjU1JTJDJTIwMjU1JTJDJTIwMC4yJTI5JTI3JTNCJTIwZHJvcFpvbmUuc3R5bGUuYmFja2dyb3VuZENvbG9yJTIwJTNEJTIwJTI3cmdiYSUyODI1NSUyQyUyMDI1NSUyQyUyMDI1NSUyQyUyMDAuMDglMjklMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGUuZGF0YVRyYW5zZmVyLmZpbGVzJTIwJTI2JTI2JTIwZS5kYXRhVHJhbnNmZXIuZmlsZXMubGVuZ3RoJTIwJTNFJTIwMCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGJhdGNoRmlsZXNJbnB1dC5maWxlcyUyMCUzRCUyMGUuZGF0YVRyYW5zZmVyLmZpbGVzJTNCJTIwYmF0Y2hGaWxlc0lucHV0LmRpc3BhdGNoRXZlbnQlMjhuZXclMjBFdmVudCUyOCUyN2NoYW5nZSUyNyUyOSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMGZ1bmN0aW9uJTIwcmVzZXRCYXRjaCUyOGNsZWFySW5wdXQlMjAlM0QlMjB0cnVlJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYmF0Y2hVcmxzLmZvckVhY2glMjh1cmwlMjAlM0QlM0UlMjBVUkwucmV2b2tlT2JqZWN0VVJMJTI4dXJsJTI5JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYmF0Y2hGaWxlcyUyMCUzRCUyMCU1QiU1RCUzQiUyMGJhdGNoVXJscyUyMCUzRCUyMCU1QiU1RCUzQiUyMHByb2Nlc3NlZFVybHMlMjAlM0QlMjAlNUIlNUQlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGNsZWFySW5wdXQlMjklMjBiYXRjaEZpbGVzSW5wdXQudmFsdWUlMjAlM0QlMjAlMjclMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBiYXRjaExpc3RDb250YWluZXIuaW5uZXJIVE1MJTIwJTNEJTIwJTI3JTNDZGl2JTIwc3R5bGUlM0QlMjJ0ZXh0LWFsaWduJTNBJTIwY2VudGVyJTNCJTIwY29sb3IlM0ElMjAlMjM2NDc0OGIlM0IlMjBmb250LXNpemUlM0ElMjAwLjk1cmVtJTNCJTIwbWFyZ2luJTNBJTIwYXV0byUzQiUyMHBhZGRpbmclM0ElMjA0MHB4JTIwMCUzQiUyMiUzRSVEOSU4MSVEOCVBNyVEQiU4QyVEOSU4NCVEQiU4QyUyMCVEOCVBNyVEOSU4NiVEOCVBQSVEOCVBRSVEOCVBNyVEOCVBOCUyMCVEOSU4NiVEOCVCNCVEOCVBRiVEOSU4NyUyMCVEOCVBNyVEOCVCMyVEOCVBQS4uLiUzQy9kaXYlM0UlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBiYXRjaExpc3RUaXRsZS50ZXh0Q29udGVudCUyMCUzRCUyMCU2MCVEOSU4NCVEQiU4QyVEOCVCMyVEOCVBQSUyMCVEOCVBQSVEOCVCNSVEOCVBNyVEOSU4OCVEQiU4QyVEOCVCMSUyMCUyOCVEQiVCMCUyOSU2MCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHN0YXJ0QmF0Y2hCdG4uZGlzYWJsZWQlMjAlM0QlMjB0cnVlJTNCJTIwc3RhcnRCYXRjaEJ0bi5pbm5lckhUTUwlMjAlM0QlMjAlMjclRTIlOUElOTklRUYlQjglOEYlMjAlRDglQjQlRDglQjElRDklODglRDglQjklMjAlRDklQkUlRDglQjElRDglQUYlRDglQTclRDglQjIlRDglQjQlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzdGFydEJhdGNoQnRuLnN0eWxlLmJhY2tncm91bmQlMjAlM0QlMjAlMjdyZ2JhJTI4MTY4JTJDJTIwODUlMkMlMjAyNDclMkMlMjAwLjE1JTI5JTI3JTNCJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5jb2xvciUyMCUzRCUyMCUyNyUyM2Q4YjRmZSUyNyUzQiUyMHN0YXJ0QmF0Y2hCdG4uc3R5bGUuYm9yZGVyQ29sb3IlMjAlM0QlMjAlMjclMjNhODU1ZjclMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb3dubG9hZEFsbEJhdGNoQnRuLnN0eWxlLmRpc3BsYXklMjAlM0QlMjAlMjdub25lJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTdEJTBBJTBBJTIwJTIwJTIwJTIwcmVzZXRCYXRjaEJ0bi5hZGRFdmVudExpc3RlbmVyJTI4JTI3Y2xpY2slMjclMkMlMjAlMjglMjklMjAlM0QlM0UlMjByZXNldEJhdGNoJTI4dHJ1ZSUyOSUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMGZ1bmN0aW9uJTIwZm9ybWF0Qnl0ZXMlMjhieXRlcyUyQyUyMGRlY2ltYWxzJTIwJTNEJTIwMiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4JTIxJTJCYnl0ZXMlMjklMjByZXR1cm4lMjAlMjcwJTIwQnl0ZXMlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGslMjAlM0QlMjAxMDI0JTNCJTIwY29uc3QlMjBkbSUyMCUzRCUyMGRlY2ltYWxzJTIwJTNDJTIwMCUyMCUzRiUyMDAlMjAlM0ElMjBkZWNpbWFscyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwc2l6ZXMlMjAlM0QlMjAlNUIlMjdCeXRlcyUyNyUyQyUyMCUyN0tCJTI3JTJDJTIwJTI3TUIlMjclMkMlMjAlMjdHQiUyNyUyQyUyMCUyN1RCJTI3JTVEJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBpJTIwJTNEJTIwTWF0aC5mbG9vciUyOE1hdGgubG9nJTI4Ynl0ZXMlMjklMjAvJTIwTWF0aC5sb2clMjhrJTI5JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwcmV0dXJuJTIwJTYwJTI0JTdCcGFyc2VGbG9hdCUyOCUyOGJ5dGVzJTIwLyUyME1hdGgucG93JTI4ayUyQyUyMGklMjklMjkudG9GaXhlZCUyOGRtJTI5JTI5JTdEJTIwJTI0JTdCc2l6ZXMlNUJpJTVEJTdEJTYwJTNCJTBBJTIwJTIwJTIwJTIwJTdEJTBBJTBBJTIwJTIwJTIwJTIwZnVuY3Rpb24lMjBoZXhUb1JnYiUyOGhleCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHZhciUyMHJlc3VsdCUyMCUzRCUyMC8lNUUlMjMlM0YlMjglNUJhLWYlNUNkJTVEJTdCMiU3RCUyOSUyOCU1QmEtZiU1Q2QlNUQlN0IyJTdEJTI5JTI4JTVCYS1mJTVDZCU1RCU3QjIlN0QlMjklMjQvaS5leGVjJTI4aGV4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwcmV0dXJuJTIwcmVzdWx0JTIwJTNGJTIwJTdCJTIwciUzQSUyMHBhcnNlSW50JTI4cmVzdWx0JTVCMSU1RCUyQyUyMDE2JTI5JTJDJTIwZyUzQSUyMHBhcnNlSW50JTI4cmVzdWx0JTVCMiU1RCUyQyUyMDE2JTI5JTJDJTIwYiUzQSUyMHBhcnNlSW50JTI4cmVzdWx0JTVCMyU1RCUyQyUyMDE2JTI5JTIwJTdEJTIwJTNBJTIwJTdCciUzQTI1NSUyQyUyMGclM0EyNTUlMkMlMjBiJTNBMjU1JTdEJTNCJTBBJTIwJTIwJTIwJTIwJTdEJTBBJTBBJTIwJTIwJTIwJTIwYmF0Y2hGaWxlc0lucHV0LmFkZEV2ZW50TGlzdGVuZXIlMjglMjdjaGFuZ2UlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjhlLnRhcmdldC5maWxlcy5sZW5ndGglMjAlM0QlM0QlM0QlMjAwJTI5JTIwcmV0dXJuJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBuZXdGaWxlcyUyMCUzRCUyMEFycmF5LmZyb20lMjhlLnRhcmdldC5maWxlcyUyOS5maWx0ZXIlMjhmaWxlJTIwJTNEJTNFJTIwZmlsZS50eXBlLnN0YXJ0c1dpdGglMjglMjdpbWFnZS8lMjclMjklMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOG5ld0ZpbGVzLmxlbmd0aCUyMCUzRCUzRCUzRCUyMDAlMjklMjAlN0IlMjBhbGVydCUyOCUyNyVEOSU4NCVEOCVCNyVEOSU4MSVEOCVBNyUyMCVEOSU4MSVEOSU4MiVEOCVCNyUyMCVEOSU4MSVEOCVBNyVEQiU4QyVEOSU4NCVFMiU4MCU4QyVEOSU4NyVEOCVBNyVEQiU4QyUyMCVEOCVBQSVEOCVCNSVEOSU4OCVEQiU4QyVEOCVCMSVEQiU4QyUyMCVEOCVBNyVEOSU4NiVEOCVBQSVEOCVBRSVEOCVBNyVEOCVBOCUyMCVEQSVBOSVEOSU4NiVEQiU4QyVEOCVBRi4lMjclMjklM0IlMjByZXR1cm4lM0IlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGJhdGNoRmlsZXMubGVuZ3RoJTIwJTNEJTNEJTNEJTIwMCUyOSUyMGJhdGNoTGlzdENvbnRhaW5lci5pbm5lckhUTUwlMjAlM0QlMjAlMjclMjclM0IlMEElMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHN0YXJ0SW5kZXglMjAlM0QlMjBiYXRjaEZpbGVzLmxlbmd0aCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGJhdGNoRmlsZXMlMjAlM0QlMjBiYXRjaEZpbGVzLmNvbmNhdCUyOG5ld0ZpbGVzJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwcHJvY2Vzc2VkVXJscyUyMCUzRCUyMHByb2Nlc3NlZFVybHMuY29uY2F0JTI4bmV3JTIwQXJyYXklMjhuZXdGaWxlcy5sZW5ndGglMjkuZmlsbCUyOG51bGwlMjklMjklM0IlMEElMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBiYXRjaExpc3RUaXRsZS50ZXh0Q29udGVudCUyMCUzRCUyMCU2MCVEOSU4NCVEQiU4QyVEOCVCMyVEOCVBQSUyMCVEOCVBQSVEOCVCNSVEOCVBNyVEOSU4OCVEQiU4QyVEOCVCMSUyMCUyOCUyNCU3QmJhdGNoRmlsZXMubGVuZ3RoJTdEJTI5JTYwJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5kaXNhYmxlZCUyMCUzRCUyMGZhbHNlJTNCJTIwc3RhcnRCYXRjaEJ0bi5pbm5lckhUTUwlMjAlM0QlMjAlMjclRTIlOUElOTklRUYlQjglOEYlMjAlRDklQkUlRDglQjElRDglQUYlRDglQTclRDglQjIlRDglQjQlMjAlRDglQjMlRDglQTYlRDklODglMjAlRDklODglMjAlRDklODElRDglQjQlRDglQjElRDglQUYlRDklODclRTIlODAlOEMlRDglQjMlRDglQTclRDglQjIlREIlOEMlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzdGFydEJhdGNoQnRuLnN0eWxlLmJhY2tncm91bmQlMjAlM0QlMjAlMjclMjNhODU1ZjclMjclM0IlMjBzdGFydEJhdGNoQnRuLnN0eWxlLmJvcmRlckNvbG9yJTIwJTNEJTIwJTI3JTIzOTMzM2VhJTI3JTNCJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5jb2xvciUyMCUzRCUyMCUyNyUyM2ZmZmZmZiUyNyUzQiUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMG5ld0ZpbGVzLmZvckVhY2glMjglMjhmaWxlJTJDJTIwaWR4JTI5JTIwJTNEJTNFJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBnbG9iYWxJbmRleCUyMCUzRCUyMHN0YXJ0SW5kZXglMjAlMkIlMjBpZHglM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHVybCUyMCUzRCUyMFVSTC5jcmVhdGVPYmplY3RVUkwlMjhmaWxlJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYmF0Y2hVcmxzLnB1c2glMjh1cmwlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMG9yaWdpbmFsU2l6ZSUyMCUzRCUyMGZvcm1hdEJ5dGVzJTI4ZmlsZS5zaXplJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBpdGVtJTIwJTNEJTIwZG9jdW1lbnQuY3JlYXRlRWxlbWVudCUyOCUyN2RpdiUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGl0ZW0uY2xhc3NOYW1lJTIwJTNEJTIwJTI3YmF0Y2gtaXRlbSUyNyUzQiUyMGl0ZW0uaWQlMjAlM0QlMjAlNjBiYXRjaC1pdGVtLSUyNCU3Qmdsb2JhbEluZGV4JTdEJTYwJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaXRlbS5pbm5lckhUTUwlMjAlM0QlMjAlNjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NkaXYlMjBjbGFzcyUzRCUyMmJhdGNoLXRodW1iLXdyYXBwZXIlMjBjdXJzb3ItcG9pbnRlciUyMGdyb3VwJTIyJTIwb25jbGljayUzRCUyMndpbmRvdy5vcGVuQ29tcGFyZSUyOCUyNCU3Qmdsb2JhbEluZGV4JTdEJTI5JTIyJTIwdGl0bGUlM0QlMjIlRDglQTglRDglQjElRDglQTclREIlOEMlMjAlRDklODUlRDklODIlRDglQTclREIlOEMlRDglQjMlRDklODclMjAlREElQTklRDklODQlREIlOEMlREElQTklMjAlREElQTklRDklODYlREIlOEMlRDglQUYlMjIlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NpbWclMjBzcmMlM0QlMjIlMjQlN0J1cmwlN0QlMjIlMjBjbGFzcyUzRCUyMmJhdGNoLXRodW1iJTIwZ3JvdXAtaG92ZXIlM0FvcGFjaXR5LTQwJTIwdHJhbnNpdGlvbiUyMGR1cmF0aW9uLTMwMCUyMiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2RpdiUyMGNsYXNzJTNEJTIyYWJzb2x1dGUlMjBpbnNldC0wJTIwZmxleCUyMGp1c3RpZnktY2VudGVyJTIwaXRlbXMtY2VudGVyJTIwb3BhY2l0eS0wJTIwZ3JvdXAtaG92ZXIlM0FvcGFjaXR5LTEwMCUyMHRyYW5zaXRpb24lMjBkdXJhdGlvbi0zMDAlMjIlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NzcGFuJTIwY2xhc3MlM0QlMjJiZy1ibGFjay85MCUyMHRleHQtd2hpdGUlMjB0ZXh0LSU1QjEwcHglNUQlMjBweC0xLjUlMjBweS0wLjUlMjByb3VuZGVkJTIwYm9yZGVyJTIwYm9yZGVyLXppbmMtNTAwJTIwc2hhZG93LWxnJTIyJTNFJUQ5JTg1JUQ5JTgyJUQ4JUE3JURCJThDJUQ4JUIzJUQ5JTg3JTNDL3NwYW4lM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MvZGl2JTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDL2RpdiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2RpdiUyMGNsYXNzJTNEJTIyYmF0Y2gtaW5mbyUyMiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2RpdiUyMGNsYXNzJTNEJTIyYmF0Y2gtbmFtZSUyMiUyMGRpciUzRCUyMmx0ciUyMiUyMHN0eWxlJTNEJTIydGV4dC1hbGlnbiUzQSUyMHJpZ2h0JTNCJTIyJTNFJTI0JTdCZmlsZS5uYW1lJTdEJTNDL2RpdiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2RpdiUyMGNsYXNzJTNEJTIyYmF0Y2gtc3RhdHMlMjIlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NzcGFuJTIwY2xhc3MlM0QlMjJzdGF0LWJhZGdlJTIyJTIwZGlyJTNEJTIybHRyJTIyJTIwdGl0bGUlM0QlMjIlRDglQUQlRDglQUMlRDklODUlMjAlRDglQTclRDklODglRDklODQlREIlOEMlRDklODclMjIlM0UlMjQlN0JvcmlnaW5hbFNpemUlN0QlM0Mvc3BhbiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ3NwYW4lMjBpZCUzRCUyMmJhdGNoLW5ld3NpemUtJTI0JTdCZ2xvYmFsSW5kZXglN0QlMjIlMjBzdHlsZSUzRCUyMmRpc3BsYXklM0ElMjBub25lJTNCJTIwYWxpZ24taXRlbXMlM0ElMjBjZW50ZXIlM0IlMjBnYXAlM0ElMjA2cHglM0IlMjIlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NzdmclMjBjbGFzcyUzRCUyMnctNCUyMGgtNCUyMHRleHQtemluYy01MDAlMjIlMjBmaWxsJTNEJTIybm9uZSUyMiUyMHN0cm9rZSUzRCUyMmN1cnJlbnRDb2xvciUyMiUyMHZpZXdCb3glM0QlMjIwJTIwMCUyMDI0JTIwMjQlMjIlM0UlM0NwYXRoJTIwc3Ryb2tlLWxpbmVjYXAlM0QlMjJyb3VuZCUyMiUyMHN0cm9rZS1saW5lam9pbiUzRCUyMnJvdW5kJTIyJTIwc3Ryb2tlLXdpZHRoJTNEJTIyMiUyMiUyMGQlM0QlMjJNMTAlMjAxOWwtNy03bTAlMjAwbDctN20tNyUyMDdoMTglMjIlM0UlM0MvcGF0aCUzRSUzQy9zdmclM0UlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NzcGFuJTIwY2xhc3MlM0QlMjJzdGF0LWJhZGdlJTIwc3RhdC1uZXclMjIlMjBkaXIlM0QlMjJsdHIlMjIlMjB0aXRsZSUzRCUyMiVEOCVBRCVEOCVBQyVEOSU4NSUyMCVEOCVBOCVEOSU4NyVEQiU4QyVEOSU4NiVEOSU4NyVFMiU4MCU4QyVEOCVCNCVEOCVBRiVEOSU4NyUyMiUzRS4uLiUzQy9zcGFuJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDL3NwYW4lM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MvZGl2JTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDL2RpdiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2RpdiUyMGNsYXNzJTNEJTIyYmF0Y2gtYWN0aW9uJTIyJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDc3BhbiUyMGlkJTNEJTIyYmF0Y2gtc3RhdHVzLSUyNCU3Qmdsb2JhbEluZGV4JTdEJTIyJTIwc3R5bGUlM0QlMjJmb250LXNpemUlM0ElMjAwLjhyZW0lM0IlMjBjb2xvciUzQSUyMCUyMzk0YTNiOCUzQiUyMG1hcmdpbi1sZWZ0JTNBJTIwMTBweCUzQiUyMiUzRSVEOCVBMiVEOSU4NSVEOCVBNyVEOCVBRiVEOSU4NyUyMCVEOSVCRSVEOCVCMSVEOCVBRiVEOCVBNyVEOCVCMiVEOCVCNCUzQy9zcGFuJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDYnV0dG9uJTIwaWQlM0QlMjJiYXRjaC1kbC1idG4tJTI0JTdCZ2xvYmFsSW5kZXglN0QlMjIlMjBjbGFzcyUzRCUyMmJ0biUyMiUyMHN0eWxlJTNEJTIycGFkZGluZyUzQSUyMDZweCUyMDEycHglM0IlMjBmb250LXNpemUlM0ElMjAwLjc1cmVtJTNCJTIwZGlzcGxheSUzQSUyMG5vbmUlM0IlMjIlM0UlRDglQUYlRDglQTclRDklODYlRDklODQlRDklODglRDglQUYlM0MvYnV0dG9uJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDL2RpdiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU2MCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGJhdGNoTGlzdENvbnRhaW5lci5hcHBlbmRDaGlsZCUyOGl0ZW0lMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCU2MGJhdGNoLWRsLWJ0bi0lMjQlN0JnbG9iYWxJbmRleCU3RCU2MCUyOS5hZGRFdmVudExpc3RlbmVyJTI4JTI3Y2xpY2slMjclMkMlMjAlMjglMjklMjAlM0QlM0UlMjAlN0IlMjBkb3dubG9hZFNpbmdsZUJhdGNoJTI4Z2xvYmFsSW5kZXglMjklM0IlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBiYXRjaEZpbGVzSW5wdXQudmFsdWUlMjAlM0QlMjAlMjclMjclM0IlMEElMjAlMjAlMjAlMjAlN0QlMjklM0IlMEElMEElMjAlMjAlMjAlMjBmdW5jdGlvbiUyMGRvd25sb2FkU2luZ2xlQmF0Y2glMjhpbmRleCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZGF0YVVybCUyMCUzRCUyMHByb2Nlc3NlZFVybHMlNUJpbmRleCU1RCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4JTIxZGF0YVVybCUyOSUyMHJldHVybiUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZm9ybWF0JTIwJTNEJTIwYmF0Y2hGb3JtYXQudmFsdWUlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGV4dCUyMCUzRCUyMGZvcm1hdCUyMCUzRCUzRCUzRCUyMCUyN2ltYWdlL2pwZWclMjclMjAlM0YlMjAlMjdqcGclMjclMjAlM0ElMjAlMjhmb3JtYXQlMjAlM0QlM0QlM0QlMjAlMjdpbWFnZS9wbmclMjclMjAlM0YlMjAlMjdwbmclMjclMjAlM0ElMjAlMjd3ZWJwJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBwcmVmaXglMjAlM0QlMjBiYXRjaFByZWZpeC52YWx1ZS50cmltJTI4JTI5JTIwJTdDJTdDJTIwJTI3SW1hZ2UlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGxpbmslMjAlM0QlMjBkb2N1bWVudC5jcmVhdGVFbGVtZW50JTI4JTI3YSUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGxpbmsuZG93bmxvYWQlMjAlM0QlMjAlNjAlMjQlN0JwcmVmaXglN0RfJTI0JTdCaW5kZXglMkIxJTdELiUyNCU3QmV4dCU3RCU2MCUzQiUyMGxpbmsuaHJlZiUyMCUzRCUyMGRhdGFVcmwlM0IlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb2N1bWVudC5ib2R5LmFwcGVuZENoaWxkJTI4bGluayUyOSUzQiUyMGxpbmsuY2xpY2slMjglMjklM0IlMjBkb2N1bWVudC5ib2R5LnJlbW92ZUNoaWxkJTI4bGluayUyOSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUwQSUwQSUyMCUyMCUyMCUyMC8vJTIwU3RlcC1kb3duJTIwcmVzaXplJTIwYWxnb3JpdGhtJTIwdG8lMjBwcmV2ZW50JTIwcGl4ZWxhdGlvbiUyMG9uJTIwbGFyZ2UlMjBkb3duc2NhbGVzJTBBJTIwJTIwJTIwJTIwZnVuY3Rpb24lMjByZXNpemVTdGVwRG93biUyOGltZyUyQyUyMHRhcmdldFclMkMlMjB0YXJnZXRIJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbGV0JTIwY3VyVyUyMCUzRCUyMGltZy53aWR0aCUzQiUyMGxldCUyMGN1ckglMjAlM0QlMjBpbWcuaGVpZ2h0JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbGV0JTIwY3VySW1nJTIwJTNEJTIwaW1nJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwd2hpbGUlMjAlMjhjdXJXJTIwJTJBJTIwMC41JTIwJTNFJTIwdGFyZ2V0VyUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwdENhbnZhcyUyMCUzRCUyMGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQlMjglMjdjYW52YXMlMjclMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdXJXJTIwJTNEJTIwTWF0aC5mbG9vciUyOGN1clclMjAlMkElMjAwLjUlMjklM0IlMjBjdXJIJTIwJTNEJTIwTWF0aC5mbG9vciUyOGN1ckglMjAlMkElMjAwLjUlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjB0Q2FudmFzLndpZHRoJTIwJTNEJTIwY3VyVyUzQiUyMHRDYW52YXMuaGVpZ2h0JTIwJTNEJTIwY3VySCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwdEN0eCUyMCUzRCUyMHRDYW52YXMuZ2V0Q29udGV4dCUyOCUyNzJkJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwdEN0eC5kcmF3SW1hZ2UlMjhjdXJJbWclMkMlMjAwJTJDJTIwMCUyQyUyMGN1clclMkMlMjBjdXJIJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3VySW1nJTIwJTNEJTIwdENhbnZhcyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZmluYWxDYW52YXMlMjAlM0QlMjBkb2N1bWVudC5jcmVhdGVFbGVtZW50JTI4JTI3Y2FudmFzJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZmluYWxDYW52YXMud2lkdGglMjAlM0QlMjB0YXJnZXRXJTNCJTIwZmluYWxDYW52YXMuaGVpZ2h0JTIwJTNEJTIwdGFyZ2V0SCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZkN0eCUyMCUzRCUyMGZpbmFsQ2FudmFzLmdldENvbnRleHQlMjglMjcyZCUyNyUyQyUyMCU3QiUyMHdpbGxSZWFkRnJlcXVlbnRseSUzQSUyMHRydWUlMjAlN0QlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBmQ3R4LmRyYXdJbWFnZSUyOGN1ckltZyUyQyUyMDAlMkMlMjAwJTJDJTIwdGFyZ2V0VyUyQyUyMHRhcmdldEglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjByZXR1cm4lMjAlN0IlMjBjYW52YXMlM0ElMjBmaW5hbENhbnZhcyUyQyUyMGN0eCUzQSUyMGZDdHglMjAlN0QlM0IlMEElMjAlMjAlMjAlMjAlN0QlMEElMEElMjAlMjAlMjAlMjAvLyUyMEFwcGx5JTIwbWlsZCUyMHNoYXJwZW5pbmclMjBtYXRyaXglMjB0byUyMGNvbXBlbnNhdGUlMjBmb3IlMjBkb3duc2NhbGluZyUyMGJsdXIlMEElMjAlMjAlMjAlMjBmdW5jdGlvbiUyMGFwcGx5TWlsZFNoYXJwZW4lMjhjdHglMkMlMjB3JTJDJTIwaCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwaW1nRGF0YSUyMCUzRCUyMGN0eC5nZXRJbWFnZURhdGElMjgwJTJDJTIwMCUyQyUyMHclMkMlMjBoJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBkYXRhJTIwJTNEJTIwaW1nRGF0YS5kYXRhJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBmYWN0b3IlMjAlM0QlMjAwLjMlM0IlMjAvLyUyMExpZ2h0JTIwc2hhcnBlbmluZyUyMGZhY3RvciUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwbWl4JTIwJTNEJTIwJTVCJTIwMCUyQyUyMC1mYWN0b3IlMkMlMjAwJTJDJTIwLWZhY3RvciUyQyUyMDElMkIlMjg0JTJBZmFjdG9yJTI5JTJDJTIwLWZhY3RvciUyQyUyMDAlMkMlMjAtZmFjdG9yJTJDJTIwMCUyMCU1RCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwb3V0RGF0YSUyMCUzRCUyMG5ldyUyMEltYWdlRGF0YSUyOHclMkMlMjBoJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBvdXQlMjAlM0QlMjBvdXREYXRhLmRhdGElM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBmb3IlMjAlMjhsZXQlMjB5JTIwJTNEJTIwMSUzQiUyMHklMjAlM0MlMjBoJTIwLSUyMDElM0IlMjB5JTJCJTJCJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZm9yJTIwJTI4bGV0JTIweCUyMCUzRCUyMDElM0IlMjB4JTIwJTNDJTIwdyUyMC0lMjAxJTNCJTIweCUyQiUyQiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZHN0T2ZmJTIwJTNEJTIwJTI4eSUyMCUyQSUyMHclMjAlMkIlMjB4JTI5JTIwJTJBJTIwNCUzQiUyMGxldCUyMHIlMjAlM0QlMjAwJTJDJTIwZyUyMCUzRCUyMDAlMkMlMjBiJTIwJTNEJTIwMCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZvciUyMCUyOGxldCUyMGN5JTIwJTNEJTIwLTElM0IlMjBjeSUyMCUzQyUzRCUyMDElM0IlMjBjeSUyQiUyQiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZvciUyMCUyOGxldCUyMGN4JTIwJTNEJTIwLTElM0IlMjBjeCUyMCUzQyUzRCUyMDElM0IlMjBjeCUyQiUyQiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwc2NPZmYlMjAlM0QlMjAlMjglMjh5JTIwJTJCJTIwY3klMjklMjAlMkElMjB3JTIwJTJCJTIwJTI4eCUyMCUyQiUyMGN4JTI5JTI5JTIwJTJBJTIwNCUyQyUyMHd0JTIwJTNEJTIwbWl4JTVCJTI4Y3klMjAlMkIlMjAxJTI5JTIwJTJBJTIwMyUyMCUyQiUyMCUyOGN4JTIwJTJCJTIwMSUyOSU1RCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHIlMjAlMkIlM0QlMjBkYXRhJTVCc2NPZmYlNUQlMjAlMkElMjB3dCUzQiUyMGclMjAlMkIlM0QlMjBkYXRhJTVCc2NPZmYlMjAlMkIlMjAxJTVEJTIwJTJBJTIwd3QlM0IlMjBiJTIwJTJCJTNEJTIwZGF0YSU1QnNjT2ZmJTIwJTJCJTIwMiU1RCUyMCUyQSUyMHd0JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwb3V0JTVCZHN0T2ZmJTVEJTIwJTNEJTIwciUzQiUyMG91dCU1QmRzdE9mZiUyQjElNUQlMjAlM0QlMjBnJTNCJTIwb3V0JTVCZHN0T2ZmJTJCMiU1RCUyMCUzRCUyMGIlM0IlMjBvdXQlNUJkc3RPZmYlMkIzJTVEJTIwJTNEJTIwZGF0YSU1QmRzdE9mZiUyQjMlNUQlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHgucHV0SW1hZ2VEYXRhJTI4b3V0RGF0YSUyQyUyMDAlMkMlMjAwJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTdEJTBBJTBBJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5hZGRFdmVudExpc3RlbmVyJTI4JTI3Y2xpY2slMjclMkMlMjBhc3luYyUyMCUyOCUyOSUyMCUzRCUzRSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4JTIxYmF0Y2hGaWxlcy5sZW5ndGglMjklMjByZXR1cm4lM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzdGFydEJhdGNoQnRuLmRpc2FibGVkJTIwJTNEJTIwdHJ1ZSUzQiUyMHN0YXJ0QmF0Y2hCdG4uaW5uZXJIVE1MJTIwJTNEJTIwJTI3JUUyJThGJUIzJTIwJUQ4JUFGJUQ4JUIxJTIwJUQ4JUFEJUQ4JUE3JUQ5JTg0JTIwJUQ4JUE4JUQ5JTg3JURCJThDJUQ5JTg2JUQ5JTg3JUUyJTgwJThDJUQ4JUIzJUQ4JUE3JUQ4JUIyJURCJThDLi4uJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5iYWNrZ3JvdW5kJTIwJTNEJTIwJTI3JTIzNmI3MjgwJTI3JTNCJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5ib3JkZXJDb2xvciUyMCUzRCUyMCUyNyUyMzRiNTU2MyUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRvd25sb2FkQWxsQmF0Y2hCdG4uc3R5bGUuZGlzcGxheSUyMCUzRCUyMCUyN25vbmUlMjclM0IlMEElMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHElMjAlM0QlMjBxdWFsaXR5TGV2ZWxzJTVCcGFyc2VJbnQlMjhiYXRjaFF1YWxpdHkudmFsdWUlMjklNUQudmFsJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBmb3JtYXQlMjAlM0QlMjBiYXRjaEZvcm1hdC52YWx1ZSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwbWF4RGltU3RyJTIwJTNEJTIwYmF0Y2hNYXhXaWR0aC52YWx1ZS50cmltJTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBtYXhEaW0lMjAlM0QlMjBtYXhEaW1TdHIlMjAlM0QlM0QlM0QlMjAlMjclMjclMjAlM0YlMjAwJTIwJTNBJTIwJTI4cGFyc2VJbnQlMjhtYXhEaW1TdHIlMjklMjAlN0MlN0MlMjAwJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZm9yJTIwJTI4bGV0JTIwaSUyMCUzRCUyMDAlM0IlMjBpJTIwJTNDJTIwYmF0Y2hGaWxlcy5sZW5ndGglM0IlMjBpJTJCJTJCJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBzdGF0dXNFbCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTYwYmF0Y2gtc3RhdHVzLSUyNCU3QmklN0QlNjAlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGl0ZW1FbCUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTYwYmF0Y2gtaXRlbS0lMjQlN0JpJTdEJTYwJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaXRlbUVsLmNsYXNzTGlzdC5yZW1vdmUlMjglMjdkb25lJTI3JTI5JTNCJTIwc3RhdHVzRWwuc3R5bGUuZGlzcGxheSUyMCUzRCUyMCUyN2lubGluZS1ibG9jayUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTYwYmF0Y2gtZGwtYnRuLSUyNCU3QmklN0QlNjAlMjkuc3R5bGUuZGlzcGxheSUyMCUzRCUyMCUyN25vbmUlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCU2MGJhdGNoLW5ld3NpemUtJTI0JTdCaSU3RCU2MCUyOS5zdHlsZS5kaXNwbGF5JTIwJTNEJTIwJTI3bm9uZSUyNyUzQiUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHN0YXR1c0VsLnRleHRDb250ZW50JTIwJTNEJTIwJTI3JUQ4JUFGJUQ4JUIxJTIwJUQ4JUFEJUQ4JUE3JUQ5JTg0JTIwJUQ5JUJFJUQ4JUIxJUQ4JUFGJUQ4JUE3JUQ4JUIyJUQ4JUI0Li4uJTI3JTNCJTIwc3RhdHVzRWwuc3R5bGUuY29sb3IlMjAlM0QlMjAlMjclMjNmZGUwNDclMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjB0cnklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHVybCUyMCUzRCUyMGJhdGNoVXJscyU1QmklNUQlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGltZyUyMCUzRCUyMGF3YWl0JTIwbmV3JTIwUHJvbWlzZSUyOCUyOHJlc29sdmUlMkMlMjByZWplY3QlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGltYWdlJTIwJTNEJTIwbmV3JTIwSW1hZ2UlMjglMjklM0IlMjBpbWFnZS5vbmxvYWQlMjAlM0QlMjAlMjglMjklMjAlM0QlM0UlMjByZXNvbHZlJTI4aW1hZ2UlMjklM0IlMjBpbWFnZS5vbmVycm9yJTIwJTNEJTIwcmVqZWN0JTNCJTIwaW1hZ2Uuc3JjJTIwJTNEJTIwdXJsJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbGV0JTIwdGFyZ2V0VyUyMCUzRCUyMGltZy53aWR0aCUzQiUyMGxldCUyMHRhcmdldEglMjAlM0QlMjBpbWcuaGVpZ2h0JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbGV0JTIwZGlkUmVzaXplJTIwJTNEJTIwZmFsc2UlM0IlMEElMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOG1heERpbSUyMCUzRSUyMDAlMjAlMjYlMjYlMjAlMjh0YXJnZXRXJTIwJTNFJTIwbWF4RGltJTIwJTdDJTdDJTIwdGFyZ2V0SCUyMCUzRSUyMG1heERpbSUyOSUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRpZFJlc2l6ZSUyMCUzRCUyMHRydWUlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOHRhcmdldFclMjAlM0UlMjB0YXJnZXRIJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwdGFyZ2V0SCUyMCUzRCUyME1hdGgucm91bmQlMjh0YXJnZXRIJTIwJTJBJTIwJTI4bWF4RGltJTIwLyUyMHRhcmdldFclMjklMjklM0IlMjB0YXJnZXRXJTIwJTNEJTIwbWF4RGltJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwZWxzZSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHRhcmdldFclMjAlM0QlMjBNYXRoLnJvdW5kJTI4dGFyZ2V0VyUyMCUyQSUyMCUyOG1heERpbSUyMC8lMjB0YXJnZXRIJTI5JTI5JTNCJTIwdGFyZ2V0SCUyMCUzRCUyMG1heERpbSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGxldCUyMGZpbmFsQ2FudmFzJTJDJTIwY3R4JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwLy8lMjBVc2UlMjBzdGVwLWRvd24lMjByZXNpemUlMjBhbGdvcml0aG0lMjBpZiUyMGRvd25zY2FsaW5nJTIwZmFjdG9yJTIwaXMlMjBzaWduaWZpY2FudCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTI4ZGlkUmVzaXplJTIwJTI2JTI2JTIwaW1nLndpZHRoJTIwJTNFJTIwdGFyZ2V0VyUyMCUyQSUyMDEuNSUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwc3RlcFJlcyUyMCUzRCUyMHJlc2l6ZVN0ZXBEb3duJTI4aW1nJTJDJTIwdGFyZ2V0VyUyQyUyMHRhcmdldEglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBmaW5hbENhbnZhcyUyMCUzRCUyMHN0ZXBSZXMuY2FudmFzJTNCJTIwY3R4JTIwJTNEJTIwc3RlcFJlcy5jdHglM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBhcHBseU1pbGRTaGFycGVuJTI4Y3R4JTJDJTIwdGFyZ2V0VyUyQyUyMHRhcmdldEglMjklM0IlMjAvLyUyMENvbXBlbnNhdGUlMjBmb3IlMjBibHVyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwZWxzZSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZpbmFsQ2FudmFzJTIwJTNEJTIwZG9jdW1lbnQuY3JlYXRlRWxlbWVudCUyOCUyN2NhbnZhcyUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZpbmFsQ2FudmFzLndpZHRoJTIwJTNEJTIwdGFyZ2V0VyUzQiUyMGZpbmFsQ2FudmFzLmhlaWdodCUyMCUzRCUyMHRhcmdldEglM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHglMjAlM0QlMjBmaW5hbENhbnZhcy5nZXRDb250ZXh0JTI4JTI3MmQlMjclMkMlMjAlN0IlMjB3aWxsUmVhZEZyZXF1ZW50bHklM0ElMjB0cnVlJTIwJTdEJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LmRyYXdJbWFnZSUyOGltZyUyQyUyMDAlMkMlMjAwJTJDJTIwdGFyZ2V0VyUyQyUyMHRhcmdldEglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAvLyUyMEFkZCUyMHdoaXRlJTIwYmFja2dyb3VuZCUyMGZvciUyMEpQRUdzJTIwJTI4d2hpY2glMjBkb24lMjd0JTIwc3VwcG9ydCUyMHRyYW5zcGFyZW5jeSUyOSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTI4Zm9ybWF0JTIwJTNEJTNEJTNEJTIwJTI3aW1hZ2UvanBlZyUyNyUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5nbG9iYWxDb21wb3NpdGVPcGVyYXRpb24lMjAlM0QlMjAlMjdkZXN0aW5hdGlvbi1vdmVyJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LmZpbGxTdHlsZSUyMCUzRCUyMCUyNyUyM2ZmZmZmZiUyNyUzQiUyMGN0eC5maWxsUmVjdCUyODAlMkMlMjAwJTJDJTIwdGFyZ2V0VyUyQyUyMHRhcmdldEglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHguZ2xvYmFsQ29tcG9zaXRlT3BlcmF0aW9uJTIwJTNEJTIwJTI3c291cmNlLW92ZXIlMjclM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAvLyUyMFdhdGVybWFyayUyMGFwcGxpY2F0aW9uJTIwbG9naWMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOHdtRW5hYmxlLmNoZWNrZWQlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHR5cGUlMjAlM0QlMjB3bVR5cGUudmFsdWUlM0IlMjBjb25zdCUyMHBvcyUyMCUzRCUyMHdtUG9zLnZhbHVlJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBwYWRkaW5nJTIwJTNEJTIwdGFyZ2V0VyUyMCUyQSUyMDAuMDMlM0IlMjBjb25zdCUyMHNwYWNpbmdWYWwlMjAlM0QlMjBwYXJzZUZsb2F0JTI4d21UaWxlU3BhY2luZy52YWx1ZSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4dHlwZSUyMCUzRCUzRCUzRCUyMCUyN3RleHQlMjclMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHR4dCUyMCUzRCUyMHdtVGV4dC52YWx1ZS50cmltJTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjAlMjh0eHQlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMG9wYWNpdHklMjAlM0QlMjBwYXJzZUZsb2F0JTI4d21PcGFjaXR5LnZhbHVlJTI5JTNCJTIwY29uc3QlMjBzaXplUGN0JTIwJTNEJTIwcGFyc2VJbnQlMjh3bVNpemUudmFsdWUlMjklM0IlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGZvbnRTaXplJTIwJTNEJTIwdGFyZ2V0VyUyMCUyQSUyMCUyOHNpemVQY3QlMjAvJTIwMTAwJTI5JTNCJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBzZWxlY3RlZEZvbnQlMjAlM0QlMjB3bUZvbnQudmFsdWUlM0IlMjBjb25zdCUyMGNvbG9yUmdiJTIwJTNEJTIwaGV4VG9SZ2IlMjh3bUNvbG9yLnZhbHVlJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LmZvbnQlMjAlM0QlMjAlNjBib2xkJTIwJTI0JTdCZm9udFNpemUlN0RweCUyMCUyNyUyNCU3QnNlbGVjdGVkRm9udCU3RCUyNyUyQyUyMHNhbnMtc2VyaWYlNjAlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHguZmlsbFN0eWxlJTIwJTNEJTIwJTYwcmdiYSUyOCUyNCU3QmNvbG9yUmdiLnIlN0QlMkMlMjAlMjQlN0Jjb2xvclJnYi5nJTdEJTJDJTIwJTI0JTdCY29sb3JSZ2IuYiU3RCUyQyUyMCUyNCU3Qm9wYWNpdHklN0QlMjklNjAlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHguc2hhZG93Q29sb3IlMjAlM0QlMjAlNjByZ2JhJTI4MCUyQyUyMDAlMkMlMjAwJTJDJTIwJTI0JTdCb3BhY2l0eSUyMCUyQSUyMDAuOCU3RCUyOSU2MCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5zaGFkb3dCbHVyJTIwJTNEJTIwTWF0aC5tYXglMjgyJTJDJTIwZm9udFNpemUlMjAlMkElMjAwLjE1JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LnNoYWRvd09mZnNldFglMjAlM0QlMjBNYXRoLm1heCUyODElMkMlMjBmb250U2l6ZSUyMCUyQSUyMDAuMDUlMjklM0IlMjBjdHguc2hhZG93T2Zmc2V0WSUyMCUzRCUyME1hdGgubWF4JTI4MSUyQyUyMGZvbnRTaXplJTIwJTJBJTIwMC4wNSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC50ZXh0QWxpZ24lMjAlM0QlMjAlMjdjZW50ZXIlMjclM0IlMjBjdHgudGV4dEJhc2VsaW5lJTIwJTNEJTIwJTI3bWlkZGxlJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBtZXRyaWNzJTIwJTNEJTIwY3R4Lm1lYXN1cmVUZXh0JTI4dHh0JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjAlMjhwb3MlMjAlM0QlM0QlM0QlMjAlMjd0aWxlJTI3JTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LnNhdmUlMjglMjklM0IlMjBjdHgudHJhbnNsYXRlJTI4dGFyZ2V0Vy8yJTJDJTIwdGFyZ2V0SC8yJTI5JTNCJTIwY3R4LnJvdGF0ZSUyOC1NYXRoLlBJJTIwLyUyMDYlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGRpYWclMjAlM0QlMjBNYXRoLnNxcnQlMjh0YXJnZXRXJTJBdGFyZ2V0VyUyMCUyQiUyMHRhcmdldEglMkF0YXJnZXRIJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBzdGVwWCUyMCUzRCUyMCUyOG1ldHJpY3Mud2lkdGglMjAlMkIlMjBmb250U2l6ZSUyMCUyQSUyMDIlMjklMjAlMkElMjBzcGFjaW5nVmFsJTNCJTIwY29uc3QlMjBzdGVwWSUyMCUzRCUyMCUyOGZvbnRTaXplJTIwJTJBJTIwMyUyOSUyMCUyQSUyMHNwYWNpbmdWYWwlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBmb3IlMjhsZXQlMjBpeCUyMCUzRCUyMC1kaWFnJTNCJTIwaXglMjAlM0MlMjBkaWFnJTNCJTIwaXglMkIlM0RzdGVwWCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZvciUyOGxldCUyMGl5JTIwJTNEJTIwLWRpYWclM0IlMjBpeSUyMCUzQyUyMGRpYWclM0IlMjBpeSUyQiUzRHN0ZXBZJTI5JTIwJTdCJTIwY3R4LmZpbGxUZXh0JTI4dHh0JTJDJTIwaXglMkMlMjBpeSUyOSUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5yZXN0b3JlJTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwZWxzZSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGxldCUyMHglMkMlMjB5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjhwb3MlMjAlM0QlM0QlM0QlMjAlMjdjZW50ZXIlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwdGFyZ2V0Vy8yJTNCJTIweSUyMCUzRCUyMHRhcmdldEgvMiUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGVsc2UlMjBpZiUyOHBvcyUyMCUzRCUzRCUzRCUyMCUyN2JyJTI3JTI5JTIwJTdCJTIweCUyMCUzRCUyMHRhcmdldFclMjAtJTIwcGFkZGluZyUyMC0lMjBtZXRyaWNzLndpZHRoLzIlM0IlMjB5JTIwJTNEJTIwdGFyZ2V0SCUyMC0lMjBwYWRkaW5nJTIwLSUyMGZvbnRTaXplLzIlM0IlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBlbHNlJTIwaWYlMjhwb3MlMjAlM0QlM0QlM0QlMjAlMjdibCUyNyUyOSUyMCU3QiUyMHglMjAlM0QlMjBwYWRkaW5nJTIwJTJCJTIwbWV0cmljcy53aWR0aC8yJTNCJTIweSUyMCUzRCUyMHRhcmdldEglMjAtJTIwcGFkZGluZyUyMC0lMjBmb250U2l6ZS8yJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZWxzZSUyMGlmJTI4cG9zJTIwJTNEJTNEJTNEJTIwJTI3dHIlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwdGFyZ2V0VyUyMC0lMjBwYWRkaW5nJTIwLSUyMG1ldHJpY3Mud2lkdGgvMiUzQiUyMHklMjAlM0QlMjBwYWRkaW5nJTIwJTJCJTIwZm9udFNpemUvMiUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGVsc2UlMjBpZiUyOHBvcyUyMCUzRCUzRCUzRCUyMCUyN3RsJTI3JTI5JTIwJTdCJTIweCUyMCUzRCUyMHBhZGRpbmclMjAlMkIlMjBtZXRyaWNzLndpZHRoLzIlM0IlMjB5JTIwJTNEJTIwcGFkZGluZyUyMCUyQiUyMGZvbnRTaXplLzIlM0IlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHguZmlsbFRleHQlMjh0eHQlMkMlMjB4JTJDJTIweSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5zaGFkb3dCbHVyJTIwJTNEJTIwMCUzQiUyMGN0eC5zaGFkb3dPZmZzZXRYJTIwJTNEJTIwMCUzQiUyMGN0eC5zaGFkb3dPZmZzZXRZJTIwJTNEJTIwMCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUyMGVsc2UlMjBpZiUyMCUyOHR5cGUlMjAlM0QlM0QlM0QlMjAlMjdpbWFnZSUyNyUyMCUyNiUyNiUyMHdtSW1hZ2VPYmolMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMG9wYWNpdHklMjAlM0QlMjBwYXJzZUZsb2F0JTI4d21JbWdPcGFjaXR5LnZhbHVlJTI5JTNCJTIwY29uc3QlMjBzY2FsZVBjdCUyMCUzRCUyMHBhcnNlSW50JTI4d21JbWdTY2FsZS52YWx1ZSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5nbG9iYWxBbHBoYSUyMCUzRCUyMG9wYWNpdHklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHdtVGFyZ2V0VyUyMCUzRCUyMHRhcmdldFclMjAlMkElMjAlMjhzY2FsZVBjdCUyMC8lMjAxMDAlMjklM0IlMjBjb25zdCUyMHdtVGFyZ2V0SCUyMCUzRCUyMHdtSW1hZ2VPYmouaGVpZ2h0JTIwJTJBJTIwJTI4d21UYXJnZXRXJTIwLyUyMHdtSW1hZ2VPYmoud2lkdGglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOHBvcyUyMCUzRCUzRCUzRCUyMCUyN3RpbGUlMjclMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjdHguc2F2ZSUyOCUyOSUzQiUyMGN0eC50cmFuc2xhdGUlMjh0YXJnZXRXLzIlMkMlMjB0YXJnZXRILzIlMjklM0IlMjBjdHgucm90YXRlJTI4LU1hdGguUEklMjAvJTIwNiUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZGlhZyUyMCUzRCUyME1hdGguc3FydCUyOHRhcmdldFclMkF0YXJnZXRXJTIwJTJCJTIwdGFyZ2V0SCUyQXRhcmdldEglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHN0ZXBYJTIwJTNEJTIwd21UYXJnZXRXJTIwJTJBJTIwc3BhY2luZ1ZhbCUyMCUyQSUyMDEuMiUzQiUyMGNvbnN0JTIwc3RlcFklMjAlM0QlMjB3bVRhcmdldEglMjAlMkElMjBzcGFjaW5nVmFsJTIwJTJBJTIwMS4yJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZm9yJTI4bGV0JTIwaXglMjAlM0QlMjAtZGlhZyUzQiUyMGl4JTIwJTNDJTIwZGlhZyUzQiUyMGl4JTJCJTNEc3RlcFglMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBmb3IlMjhsZXQlMjBpeSUyMCUzRCUyMC1kaWFnJTNCJTIwaXklMjAlM0MlMjBkaWFnJTNCJTIwaXklMkIlM0RzdGVwWSUyOSUyMCU3QiUyMGN0eC5kcmF3SW1hZ2UlMjh3bUltYWdlT2JqJTJDJTIwaXglMjAtJTIwd21UYXJnZXRXLzIlMkMlMjBpeSUyMC0lMjB3bVRhcmdldEgvMiUyQyUyMHdtVGFyZ2V0VyUyQyUyMHdtVGFyZ2V0SCUyOSUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5yZXN0b3JlJTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwZWxzZSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGxldCUyMHglMkMlMjB5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjhwb3MlMjAlM0QlM0QlM0QlMjAlMjdjZW50ZXIlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwJTI4dGFyZ2V0VyUyMC0lMjB3bVRhcmdldFclMjkvMiUzQiUyMHklMjAlM0QlMjAlMjh0YXJnZXRIJTIwLSUyMHdtVGFyZ2V0SCUyOS8yJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZWxzZSUyMGlmJTI4cG9zJTIwJTNEJTNEJTNEJTIwJTI3YnIlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwdGFyZ2V0VyUyMC0lMjB3bVRhcmdldFclMjAtJTIwcGFkZGluZyUzQiUyMHklMjAlM0QlMjB0YXJnZXRIJTIwLSUyMHdtVGFyZ2V0SCUyMC0lMjBwYWRkaW5nJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZWxzZSUyMGlmJTI4cG9zJTIwJTNEJTNEJTNEJTIwJTI3YmwlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwcGFkZGluZyUzQiUyMHklMjAlM0QlMjB0YXJnZXRIJTIwLSUyMHdtVGFyZ2V0SCUyMC0lMjBwYWRkaW5nJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZWxzZSUyMGlmJTI4cG9zJTIwJTNEJTNEJTNEJTIwJTI3dHIlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwdGFyZ2V0VyUyMC0lMjB3bVRhcmdldFclMjAtJTIwcGFkZGluZyUzQiUyMHklMjAlM0QlMjBwYWRkaW5nJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwZWxzZSUyMGlmJTI4cG9zJTIwJTNEJTNEJTNEJTIwJTI3dGwlMjclMjklMjAlN0IlMjB4JTIwJTNEJTIwcGFkZGluZyUzQiUyMHklMjAlM0QlMjBwYWRkaW5nJTNCJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3R4LmRyYXdJbWFnZSUyOHdtSW1hZ2VPYmolMkMlMjB4JTJDJTIweSUyQyUyMHdtVGFyZ2V0VyUyQyUyMHdtVGFyZ2V0SCUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGN0eC5nbG9iYWxBbHBoYSUyMCUzRCUyMDEuMCUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwZGF0YVVybCUyMCUzRCUyMGZpbmFsQ2FudmFzLnRvRGF0YVVSTCUyOGZvcm1hdCUyQyUyMGZvcm1hdCUyMCUzRCUzRCUzRCUyMCUyN2ltYWdlL3BuZyUyNyUyMCUzRiUyMHVuZGVmaW5lZCUyMCUzQSUyMHElMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBwcm9jZXNzZWRVcmxzJTVCaSU1RCUyMCUzRCUyMGRhdGFVcmwlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGJ5dGVMZW5ndGglMjAlM0QlMjBNYXRoLnJvdW5kJTI4JTI4ZGF0YVVybC5sZW5ndGglMjAtJTIwJTYwZGF0YSUzQSUyNCU3QmZvcm1hdCU3RCUzQmJhc2U2NCUyQyU2MC5sZW5ndGglMjklMjAlMkElMjAwLjc1JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBuZXdTaXplVGV4dCUyMCUzRCUyMGZvcm1hdEJ5dGVzJTI4Ynl0ZUxlbmd0aCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGl0ZW1FbC5jbGFzc0xpc3QuYWRkJTI4JTI3ZG9uZSUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwbmV3U2l6ZUVsJTIwJTNEJTIwZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQlMjglNjBiYXRjaC1uZXdzaXplLSUyNCU3QmklN0QlNjAlMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBuZXdTaXplRWwuc3R5bGUuZGlzcGxheSUyMCUzRCUyMCUyN2lubGluZS1mbGV4JTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbmV3U2l6ZUVsLmlubmVySFRNTCUyMCUzRCUyMCU2MCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ3N2ZyUyMGNsYXNzJTNEJTIydy00JTIwaC00JTIwdGV4dC16aW5jLTUwMCUyMiUyMGZpbGwlM0QlMjJub25lJTIyJTIwc3Ryb2tlJTNEJTIyY3VycmVudENvbG9yJTIyJTIwdmlld0JveCUzRCUyMjAlMjAwJTIwMjQlMjAyNCUyMiUzRSUzQ3BhdGglMjBzdHJva2UtbGluZWNhcCUzRCUyMnJvdW5kJTIyJTIwc3Ryb2tlLWxpbmVqb2luJTNEJTIycm91bmQlMjIlMjBzdHJva2Utd2lkdGglM0QlMjIyJTIyJTIwZCUzRCUyMk0xMCUyMDE5bC03LTdtMCUyMDBsNy03bS03JTIwN2gxOCUyMiUzRSUzQy9wYXRoJTNFJTNDL3N2ZyUzRSUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ3NwYW4lMjBjbGFzcyUzRCUyMnN0YXQtYmFkZ2UlMjBzdGF0LW5ldyUyMiUyMGRpciUzRCUyMmx0ciUyMiUyMHRpdGxlJTNEJTIyJUQ4JUFEJUQ4JUFDJUQ5JTg1JTIwJUQ4JUE4JUQ5JTg3JURCJThDJUQ5JTg2JUQ5JTg3JUUyJTgwJThDJUQ4JUI0JUQ4JUFGJUQ5JTg3JTIyJTNFJTI0JTdCbmV3U2l6ZVRleHQlN0QlMjAlM0NzcGFuJTIwc3R5bGUlM0QlMjJmb250LXNpemUlM0EwLjc1cmVtJTNCb3BhY2l0eSUzQTAuOCUzQiUyMiUzRSUyOCUyNCU3QnRhcmdldFclN0R4JTI0JTdCdGFyZ2V0SCU3RCUyOSUzQy9zcGFuJTNFJTNDL3NwYW4lM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNjAlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzdGF0dXNFbC5zdHlsZS5kaXNwbGF5JTIwJTNEJTIwJTI3bm9uZSUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTYwYmF0Y2gtZGwtYnRuLSUyNCU3QmklN0QlNjAlMjkuc3R5bGUuZGlzcGxheSUyMCUzRCUyMCUyN2lubGluZS1ibG9jayUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGF3YWl0JTIwbmV3JTIwUHJvbWlzZSUyOHIlMjAlM0QlM0UlMjBzZXRUaW1lb3V0JTI4ciUyQyUyMDIwJTI5JTI5JTNCJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwY2F0Y2glMjAlMjhlcnIlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBzdGF0dXNFbC50ZXh0Q29udGVudCUyMCUzRCUyMCUyNyVEOCVBRSVEOCVCNyVEOCVBNyUyMCVEOCVBRiVEOCVCMSUyMCVEOSVCRSVEOCVCMSVEOCVBRiVEOCVBNyVEOCVCMiVEOCVCNCUyMSUyNyUzQiUyMHN0YXR1c0VsLnN0eWxlLmNvbG9yJTIwJTNEJTIwJTI3JTIzZjg3MTcxJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5pbm5lckhUTUwlMjAlM0QlMjAlMjclRTIlOUMlOTMlMjAlRDklQkUlRDglQjElRDglQUYlRDglQTclRDglQjIlRDglQjQlMjAlRDklQkUlRDglQTclREIlOEMlRDglQTclRDklODYlMjAlREIlOEMlRDglQTclRDklODElRDglQUElMjclM0IlMjBzdGFydEJhdGNoQnRuLnN0eWxlLmJhY2tncm91bmQlMjAlM0QlMjAlMjdyZ2JhJTI4MTYlMkMlMjAxODUlMkMlMjAxMjklMkMlMjAwLjE1JTI5JTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwc3RhcnRCYXRjaEJ0bi5zdHlsZS5jb2xvciUyMCUzRCUyMCUyNyUyMzM0ZDM5OSUyNyUzQiUyMHN0YXJ0QmF0Y2hCdG4uc3R5bGUuYm9yZGVyQ29sb3IlMjAlM0QlMjAlMjclMjMxMGI5ODElMjclM0IlMjBzdGFydEJhdGNoQnRuLmRpc2FibGVkJTIwJTNEJTIwZmFsc2UlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb3dubG9hZEFsbEJhdGNoQnRuLnN0eWxlLmRpc3BsYXklMjAlM0QlMjAlMjdpbmxpbmUtYmxvY2slMjclM0IlMEElMjAlMjAlMjAlMjAlN0QlMjklM0IlMEElMEElMjAlMjAlMjAlMjBkb3dubG9hZEFsbEJhdGNoQnRuLmFkZEV2ZW50TGlzdGVuZXIlMjglMjdjbGljayUyNyUyQyUyMGFzeW5jJTIwJTI4JTI5JTIwJTNEJTNFJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYWxlcnQlMjglMjclRDglQUYlRDklODIlRDglQUElMjAlREElQTklRDklODYlREIlOEMlRDglQUYlM0ElMjAlRDklODUlRDglQjElRDklODglRDglQjElREElQUYlRDglQjElMjAlRDglQTclRDglQjIlMjAlRDglQjQlRDklODUlRDglQTclMjAlRDglQTclRDglQUMlRDglQTclRDglQjIlRDklODclMjAlRDglQUYlRDglQTclRDklODYlRDklODQlRDklODglRDglQUYlMjAlREElODYlRDklODYlRDglQUYlREElQUYlRDglQTclRDklODYlRDklODclMjAlMjhBbGxvdyUyME11bHRpcGxlJTIwRG93bmxvYWRzJTI5JTIwJUQ5JTg1JURCJThDJUUyJTgwJThDJUQ4JUFFJUQ5JTg4JUQ4JUE3JUQ5JTg3JUQ4JUFGLiUyMCVEOSU4NCVEOCVCNyVEOSU4MSVEOCVBNyVEOSU4QiUyMCVEOCVBRiVEOCVCMSUyMCVEOCVCNSVEOSU4OCVEOCVCMSVEOCVBQSUyMCVEOSU4NSVEOCVCNCVEOCVBNyVEOSU4NyVEOCVBRiVEOSU4NyUyMCVEQSVBOSVEOCVBNyVEOCVBRiVEOCVCMSUyMCVEOSVCRSVEOCVBNyVEOSVCRSVFMiU4MCU4QyVEOCVBMiVEOSVCRSUyMCVEOCVBRiVEOCVCMSUyMCVEOCVBOCVEOCVBNyVEOSU4NCVEOCVBNyVEQiU4QyUyMCVEOSU4NSVEOCVCMSVEOSU4OCVEOCVCMSVEQSVBRiVEOCVCMSVEOCU4QyUyMCVEOCVBMiVEOSU4NiUyMCVEOCVCMSVEOCVBNyUyMCVEOCVBQSVEOCVBNyVEQiU4QyVEQiU4QyVEOCVBRiUyMCUyOEFsbG93JTI5JTIwJURBJUE5JUQ5JTg2JURCJThDJUQ4JUFGLiUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGZvciUyMCUyOGxldCUyMGklMjAlM0QlMjAwJTNCJTIwaSUyMCUzQyUyMHByb2Nlc3NlZFVybHMubGVuZ3RoJTNCJTIwaSUyQiUyQiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTIwJTI4cHJvY2Vzc2VkVXJscyU1QmklNUQlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBkb3dubG9hZFNpbmdsZUJhdGNoJTI4aSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGF3YWl0JTIwbmV3JTIwUHJvbWlzZSUyOHIlMjAlM0QlM0UlMjBzZXRUaW1lb3V0JTI4ciUyQyUyMDQwMCUyOSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMC8vJTIwQ29tcGFyaXNvbiUyMG1vZGFsJTIwYW5kJTIwem9vbSUyMGxvZ2ljJTBBJTIwJTIwJTIwJTIwZnVuY3Rpb24lMjB1cGRhdGVUcmFuc2Zvcm0lMjglMjklMjAlN0IlMjBjb21wSW1nLnN0eWxlLnRyYW5zZm9ybSUyMCUzRCUyMCU2MHRyYW5zbGF0ZSUyOCUyNCU3QnBhblglN0RweCUyQyUyMCUyNCU3QnBhblklN0RweCUyOSUyMHNjYWxlJTI4JTI0JTdCaW1nU2NhbGUlN0QlMjklNjAlM0IlMjAlN0QlMEElMEElMjAlMjAlMjAlMjB3aW5kb3cub3BlbkNvbXBhcmUlMjAlM0QlMjBmdW5jdGlvbiUyOGluZGV4JTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY3VycmVudENvbXBhcmVJbmRleCUyMCUzRCUyMGluZGV4JTNCJTIwY29uc3QlMjBoYXNDb21wcmVzc2VkJTIwJTNEJTIwJTIxJTIxcHJvY2Vzc2VkVXJscyU1QmluZGV4JTVEJTNCJTIwc2hvd2luZ09yaWdpbmFsJTIwJTNEJTIwJTIxaGFzQ29tcHJlc3NlZCUzQiUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGltZ1NjYWxlJTIwJTNEJTIwMSUzQiUyMHBhblglMjAlM0QlMjAwJTNCJTIwcGFuWSUyMCUzRCUyMDAlM0IlMjB1cGRhdGVUcmFuc2Zvcm0lMjglMjklM0IlMjB1cGRhdGVDb21wYXJlVmlldyUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3Y29tcGFyZU1vZGFsJTI3JTI5LmNsYXNzTGlzdC5yZW1vdmUlMjglMjdoaWRkZW4lMjclMjklM0IlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2NvbXBhcmVNb2RhbCUyNyUyOS5jbGFzc0xpc3QuYWRkJTI4JTI3ZmxleCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUzQiUwQSUwQSUyMCUyMCUyMCUyMHdpbmRvdy5jbG9zZUNvbXBhcmUlMjAlM0QlMjBmdW5jdGlvbiUyOCUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3Y29tcGFyZU1vZGFsJTI3JTI5LmNsYXNzTGlzdC5hZGQlMjglMjdoaWRkZW4lMjclMjklM0IlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2NvbXBhcmVNb2RhbCUyNyUyOS5jbGFzc0xpc3QucmVtb3ZlJTI4JTI3ZmxleCUyNyUyOSUzQiUyMGN1cnJlbnRDb21wYXJlSW5kZXglMjAlM0QlMjAtMSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUzQiUwQSUyMCUyMCUyMCUyMCUwQSUyMCUyMCUyMCUyMG1vZGFsQmcuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN2NsaWNrJTI3JTJDJTIwd2luZG93LmNsb3NlQ29tcGFyZSUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMHdpbmRvdy5zZXRTaG93T3JpZ2luYWwlMjAlM0QlMjBmdW5jdGlvbiUyOGlzT3JpZ2luYWwlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOGN1cnJlbnRDb21wYXJlSW5kZXglMjAlM0QlM0QlM0QlMjAtMSUyOSUyMHJldHVybiUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwaGFzQ29tcHJlc3NlZCUyMCUzRCUyMCUyMSUyMXByb2Nlc3NlZFVybHMlNUJjdXJyZW50Q29tcGFyZUluZGV4JTVEJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjglMjFoYXNDb21wcmVzc2VkJTIwJTI2JTI2JTIwJTIxaXNPcmlnaW5hbCUyOSUyMCU3QiUyMGFsZXJ0JTI4JTI3JUQ4JUE3JURCJThDJUQ5JTg2JTIwJUQ4JUI5JURBJUE5JUQ4JUIzJTIwJUQ5JTg3JUQ5JTg2JUQ5JTg4JUQ4JUIyJTIwJUQ5JUJFJUQ4JUIxJUQ4JUFGJUQ4JUE3JUQ4JUIyJUQ4JUI0JTIwJUQ5JTg2JUQ4JUI0JUQ4JUFGJUQ5JTg3JTIwJUQ4JUE3JUQ4JUIzJUQ4JUFBLiUyNyUyOSUzQiUyMHJldHVybiUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHNob3dpbmdPcmlnaW5hbCUyMCUzRCUyMGlzT3JpZ2luYWwlM0IlMjB1cGRhdGVDb21wYXJlVmlldyUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUzQiUwQSUwQSUyMCUyMCUyMCUyMGZ1bmN0aW9uJTIwdXBkYXRlQ29tcGFyZVZpZXclMjglMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOGN1cnJlbnRDb21wYXJlSW5kZXglMjAlM0QlM0QlM0QlMjAtMSUyOSUyMHJldHVybiUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwbGFiZWwlMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2NvbXBhcmVMYWJlbCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwYnRuT3JpZyUyMCUzRCUyMGRvY3VtZW50LmdldEVsZW1lbnRCeUlkJTI4JTI3YnRuVmlld09yaWclMjclMjklM0IlMjBjb25zdCUyMGJ0bkNvbXAlMjAlM0QlMjBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCUyOCUyN2J0blZpZXdDb21wJTI3JTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjhzaG93aW5nT3JpZ2luYWwlMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb21wSW1nLnNyYyUyMCUzRCUyMGJhdGNoVXJscyU1QmN1cnJlbnRDb21wYXJlSW5kZXglNUQlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBsYWJlbC50ZXh0Q29udGVudCUyMCUzRCUyMCUyNyVEQSVBOSVEQiU4QyVEOSU4MSVEQiU4QyVEOCVBQSUyMCVEOCVBNyVEOCVCNSVEOSU4NCVEQiU4QyUyMCUyOCVEOCVBQSVEOCVCQSVEQiU4QyVEQiU4QyVEOCVCMSUyMCVEOSU4NiVEQiU4QyVEOCVBNyVEOSU4MSVEOCVBQSVEOSU4NyUyOSUyNyUzQiUyMGxhYmVsLmNsYXNzTmFtZSUyMCUzRCUyMCUyN2Fic29sdXRlJTIwdG9wLTQlMjBsZWZ0LTQlMjBiZy16aW5jLTcwMCUyMHRleHQtd2hpdGUlMjBweC0zJTIwcHktMSUyMHJvdW5kZWQtbWQlMjB0ZXh0LXNtJTIwZm9udC1ib2xkJTIwc2hhZG93LWxnJTIwcG9pbnRlci1ldmVudHMtbm9uZSUyNyUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGJ0bk9yaWcuY2xhc3NMaXN0LnJlcGxhY2UlMjglMjdiZy16aW5jLTcwMCUyNyUyQyUyMCUyN2JnLXBpbmstNjAwJTI3JTI5JTNCJTIwYnRuT3JpZy5jbGFzc0xpc3QucmVwbGFjZSUyOCUyN3NoYWRvdy0lNUIwXzBfMTVweF9yZ2JhJTI4MCUyQzAlMkMwJTJDMC41JTI5JTVEJTI3JTJDJTIwJTI3c2hhZG93LSU1QjBfMF8xNXB4X3JnYmElMjgyMzYlMkM3MiUyQzE1MyUyQzAuNSUyOSU1RCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGJ0bkNvbXAuY2xhc3NMaXN0LnJlcGxhY2UlMjglMjdiZy1waW5rLTYwMCUyNyUyQyUyMCUyN2JnLXppbmMtNzAwJTI3JTI5JTNCJTIwYnRuQ29tcC5jbGFzc0xpc3QucmVwbGFjZSUyOCUyN3NoYWRvdy0lNUIwXzBfMTVweF9yZ2JhJTI4MjM2JTJDNzIlMkMxNTMlMkMwLjUlMjklNUQlMjclMkMlMjAlMjdzaGFkb3ctJTVCMF8wXzE1cHhfcmdiYSUyODAlMkMwJTJDMCUyQzAuNSUyOSU1RCUyNyUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUyMGVsc2UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb21wSW1nLnNyYyUyMCUzRCUyMHByb2Nlc3NlZFVybHMlNUJjdXJyZW50Q29tcGFyZUluZGV4JTVEJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwbGFiZWwudGV4dENvbnRlbnQlMjAlM0QlMjAlMjclRDglQUUlRDglQjElRDklODglRDglQUMlREIlOEMlMjAlRDklODElRDglQjQlRDglQjElRDglQUYlRDklODclRTIlODAlOEMlRDglQjQlRDglQUYlRDklODclMjclM0IlMjBsYWJlbC5jbGFzc05hbWUlMjAlM0QlMjAlMjdhYnNvbHV0ZSUyMHRvcC00JTIwbGVmdC00JTIwYmctZ3JlZW4tNjAwJTIwdGV4dC13aGl0ZSUyMHB4LTMlMjBweS0xJTIwcm91bmRlZC1tZCUyMHRleHQtc20lMjBmb250LWJvbGQlMjBzaGFkb3ctbGclMjBwb2ludGVyLWV2ZW50cy1ub25lJTI3JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYnRuT3JpZy5jbGFzc0xpc3QucmVwbGFjZSUyOCUyN2JnLXBpbmstNjAwJTI3JTJDJTIwJTI3YmctemluYy03MDAlMjclMjklM0IlMjBidG5PcmlnLmNsYXNzTGlzdC5yZXBsYWNlJTI4JTI3c2hhZG93LSU1QjBfMF8xNXB4X3JnYmElMjgyMzYlMkM3MiUyQzE1MyUyQzAuNSUyOSU1RCUyNyUyQyUyMCUyN3NoYWRvdy0lNUIwXzBfMTVweF9yZ2JhJTI4MCUyQzAlMkMwJTJDMC41JTI5JTVEJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwYnRuQ29tcC5jbGFzc0xpc3QucmVwbGFjZSUyOCUyN2JnLXppbmMtNzAwJTI3JTJDJTIwJTI3YmctcGluay02MDAlMjclMjklM0IlMjBidG5Db21wLmNsYXNzTGlzdC5yZXBsYWNlJTI4JTI3c2hhZG93LSU1QjBfMF8xNXB4X3JnYmElMjgwJTJDMCUyQzAlMkMwLjUlMjklNUQlMjclMkMlMjAlMjdzaGFkb3ctJTVCMF8wXzE1cHhfcmdiYSUyODIzNiUyQzcyJTJDMTUzJTJDMC41JTI5JTVEJTI3JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTdEJTBBJTBBJTIwJTIwJTIwJTIwd2luZG93LmFkZEV2ZW50TGlzdGVuZXIlMjglMjdrZXlkb3duJTI3JTJDJTIwJTI4ZSUyOSUyMCUzRCUzRSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTI4Y3VycmVudENvbXBhcmVJbmRleCUyMCUzRSUyMC0xJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjhlLmtleSUyMCUzRCUzRCUzRCUyMCUyN0Fycm93UmlnaHQlMjclMjklMjB3aW5kb3cuc2V0U2hvd09yaWdpbmFsJTI4dHJ1ZSUyOSUzQiUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGlmJTI4ZS5rZXklMjAlM0QlM0QlM0QlMjAlMjdBcnJvd0xlZnQlMjclMjklMjB3aW5kb3cuc2V0U2hvd09yaWdpbmFsJTI4ZmFsc2UlMjklM0IlMjAlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOGUua2V5JTIwJTNEJTNEJTNEJTIwJTI3RXNjYXBlJTI3JTI5JTIwd2luZG93LmNsb3NlQ29tcGFyZSUyOCUyOSUzQiUyMCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMGNvbXBDb250YWluZXIuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN3doZWVsJTI3JTJDJTIwJTI4ZSUyOSUyMCUzRCUzRSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGUucHJldmVudERlZmF1bHQlMjglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHpvb21TZW5zaXRpdml0eSUyMCUzRCUyMDAuMSUzQiUyMGNvbnN0JTIwZGVsdGElMjAlM0QlMjBlLmRlbHRhWSUyMCUzQyUyMDAlMjAlM0YlMjAxJTIwJTJCJTIwem9vbVNlbnNpdGl2aXR5JTIwJTNBJTIwMSUyMC0lMjB6b29tU2Vuc2l0aXZpdHklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMG5ld1NjYWxlJTIwJTNEJTIwTWF0aC5tYXglMjgxJTJDJTIwTWF0aC5taW4lMjgxNSUyQyUyMGltZ1NjYWxlJTIwJTJBJTIwZGVsdGElMjklMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMHJlY3QlMjAlM0QlMjBjb21wQ29udGFpbmVyLmdldEJvdW5kaW5nQ2xpZW50UmVjdCUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwbW91c2VYJTIwJTNEJTIwZS5jbGllbnRYJTIwLSUyMHJlY3QubGVmdCUyMC0lMjByZWN0LndpZHRoJTIwLyUyMDIlM0IlMjBjb25zdCUyMG1vdXNlWSUyMCUzRCUyMGUuY2xpZW50WSUyMC0lMjByZWN0LnRvcCUyMC0lMjByZWN0LmhlaWdodCUyMC8lMjAyJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwcGFuWCUyMCUzRCUyMG1vdXNlWCUyMC0lMjAlMjhtb3VzZVglMjAtJTIwcGFuWCUyOSUyMCUyQSUyMCUyOG5ld1NjYWxlJTIwLyUyMGltZ1NjYWxlJTI5JTNCJTIwcGFuWSUyMCUzRCUyMG1vdXNlWSUyMC0lMjAlMjhtb3VzZVklMjAtJTIwcGFuWSUyOSUyMCUyQSUyMCUyOG5ld1NjYWxlJTIwLyUyMGltZ1NjYWxlJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaW1nU2NhbGUlMjAlM0QlMjBuZXdTY2FsZSUzQiUyMGlmJTI4aW1nU2NhbGUlMjAlM0QlM0QlM0QlMjAxJTI5JTIwJTdCJTIwcGFuWCUyMCUzRCUyMDAlM0IlMjBwYW5ZJTIwJTNEJTIwMCUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHVwZGF0ZVRyYW5zZm9ybSUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUyQyUyMCU3QnBhc3NpdmUlM0ElMjBmYWxzZSU3RCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMGNvbXBDb250YWluZXIuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN21vdXNlZG93biUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyOGltZ1NjYWxlJTIwJTNEJTNEJTNEJTIwMSUyOSUyMHJldHVybiUzQiUyMGlzRHJhZ2dpbmdJbWclMjAlM0QlMjB0cnVlJTNCJTIwc3RhcnREcmFnWCUyMCUzRCUyMGUuY2xpZW50WCUyMC0lMjBwYW5YJTNCJTIwc3RhcnREcmFnWSUyMCUzRCUyMGUuY2xpZW50WSUyMC0lMjBwYW5ZJTNCJTBBJTIwJTIwJTIwJTIwJTdEJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwd2luZG93LmFkZEV2ZW50TGlzdGVuZXIlMjglMjdtb3VzZW1vdmUlMjclMkMlMjAlMjhlJTI5JTIwJTNEJTNFJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaWYlMjglMjFpc0RyYWdnaW5nSW1nJTI5JTIwcmV0dXJuJTNCJTIwcGFuWCUyMCUzRCUyMGUuY2xpZW50WCUyMC0lMjBzdGFydERyYWdYJTNCJTIwcGFuWSUyMCUzRCUyMGUuY2xpZW50WSUyMC0lMjBzdGFydERyYWdZJTNCJTIwdXBkYXRlVHJhbnNmb3JtJTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTdEJTI5JTNCJTBBJTIwJTIwJTIwJTIwd2luZG93LmFkZEV2ZW50TGlzdGVuZXIlMjglMjdtb3VzZXVwJTI3JTJDJTIwJTI4JTI5JTIwJTNEJTNFJTIwJTdCJTIwaXNEcmFnZ2luZ0ltZyUyMCUzRCUyMGZhbHNlJTNCJTIwJTdEJTI5JTNCJTBBJTBBJTIwJTIwJTIwJTIwY29tcENvbnRhaW5lci5hZGRFdmVudExpc3RlbmVyJTI4JTI3dG91Y2hzdGFydCUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGUudG91Y2hlcy5sZW5ndGglMjAlM0QlM0QlM0QlMjAyJTI5JTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaXNEcmFnZ2luZ0ltZyUyMCUzRCUyMGZhbHNlJTNCJTIwaXNQaW5jaGluZyUyMCUzRCUyMHRydWUlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBwaW5jaFN0YXJ0RGlzdCUyMCUzRCUyME1hdGguaHlwb3QlMjhlLnRvdWNoZXMlNUIwJTVELmNsaWVudFglMjAtJTIwZS50b3VjaGVzJTVCMSU1RC5jbGllbnRYJTJDJTIwZS50b3VjaGVzJTVCMCU1RC5jbGllbnRZJTIwLSUyMGUudG91Y2hlcyU1QjElNUQuY2xpZW50WSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHBpbmNoU3RhcnRTY2FsZSUyMCUzRCUyMGltZ1NjYWxlJTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTIwZWxzZSUyMGlmJTIwJTI4ZS50b3VjaGVzLmxlbmd0aCUyMCUzRCUzRCUzRCUyMDElMjAlMjYlMjYlMjBpbWdTY2FsZSUyMCUzRSUyMDElMjklMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpc0RyYWdnaW5nSW1nJTIwJTNEJTIwdHJ1ZSUzQiUyMHN0YXJ0RHJhZ1glMjAlM0QlMjBlLnRvdWNoZXMlNUIwJTVELmNsaWVudFglMjAtJTIwcGFuWCUzQiUyMHN0YXJ0RHJhZ1klMjAlM0QlMjBlLnRvdWNoZXMlNUIwJTVELmNsaWVudFklMjAtJTIwcGFuWSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUyMCU3QnBhc3NpdmUlM0ElMjBmYWxzZSU3RCUyOSUzQiUwQSUwQSUyMCUyMCUyMCUyMGNvbXBDb250YWluZXIuYWRkRXZlbnRMaXN0ZW5lciUyOCUyN3RvdWNobW92ZSUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGlzUGluY2hpbmclMjAlMjYlMjYlMjBlLnRvdWNoZXMubGVuZ3RoJTIwJTNEJTNEJTNEJTIwMiUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGUucHJldmVudERlZmF1bHQlMjglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBjb25zdCUyMGN1cnJlbnREaXN0JTIwJTNEJTIwTWF0aC5oeXBvdCUyOGUudG91Y2hlcyU1QjAlNUQuY2xpZW50WCUyMC0lMjBlLnRvdWNoZXMlNUIxJTVELmNsaWVudFglMkMlMjBlLnRvdWNoZXMlNUIwJTVELmNsaWVudFklMjAtJTIwZS50b3VjaGVzJTVCMSU1RC5jbGllbnRZJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBzY2FsZUNoYW5nZSUyMCUzRCUyMGN1cnJlbnREaXN0JTIwLyUyMHBpbmNoU3RhcnREaXN0JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBuZXdTY2FsZSUyMCUzRCUyME1hdGgubWF4JTI4MSUyQyUyME1hdGgubWluJTI4MTUlMkMlMjBwaW5jaFN0YXJ0U2NhbGUlMjAlMkElMjBzY2FsZUNoYW5nZSUyOSUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwcmVjdCUyMCUzRCUyMGNvbXBDb250YWluZXIuZ2V0Qm91bmRpbmdDbGllbnRSZWN0JTI4JTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwY29uc3QlMjBjZW50ZXJYJTIwJTNEJTIwJTI4JTI4ZS50b3VjaGVzJTVCMCU1RC5jbGllbnRYJTIwJTJCJTIwZS50b3VjaGVzJTVCMSU1RC5jbGllbnRYJTI5JTIwLyUyMDIlMjklMjAtJTIwcmVjdC5sZWZ0JTIwLSUyMHJlY3Qud2lkdGgvMiUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGNvbnN0JTIwY2VudGVyWSUyMCUzRCUyMCUyOCUyOGUudG91Y2hlcyU1QjAlNUQuY2xpZW50WSUyMCUyQiUyMGUudG91Y2hlcyU1QjElNUQuY2xpZW50WSUyOSUyMC8lMjAyJTI5JTIwLSUyMHJlY3QudG9wJTIwLSUyMHJlY3QuaGVpZ2h0LzIlM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBwYW5YJTIwJTNEJTIwY2VudGVyWCUyMC0lMjAlMjhjZW50ZXJYJTIwLSUyMHBhblglMjklMjAlMkElMjAlMjhuZXdTY2FsZSUyMC8lMjBpbWdTY2FsZSUyOSUzQiUyMHBhblklMjAlM0QlMjBjZW50ZXJZJTIwLSUyMCUyOGNlbnRlclklMjAtJTIwcGFuWSUyOSUyMCUyQSUyMCUyOG5ld1NjYWxlJTIwLyUyMGltZ1NjYWxlJTI5JTNCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwaW1nU2NhbGUlMjAlM0QlMjBuZXdTY2FsZSUzQiUyMGlmJTI4aW1nU2NhbGUlMjAlM0QlM0QlM0QlMjAxJTI5JTIwJTdCJTIwcGFuWCUyMCUzRCUyMDAlM0IlMjBwYW5ZJTIwJTNEJTIwMCUzQiUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMHVwZGF0ZVRyYW5zZm9ybSUyOCUyOSUzQiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUyMGVsc2UlMjBpZiUyMCUyOGlzRHJhZ2dpbmdJbWclMjAlMjYlMjYlMjBlLnRvdWNoZXMubGVuZ3RoJTIwJTNEJTNEJTNEJTIwMSUyOSUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMGUucHJldmVudERlZmF1bHQlMjglMjklM0IlMjBwYW5YJTIwJTNEJTIwZS50b3VjaGVzJTVCMCU1RC5jbGllbnRYJTIwLSUyMHN0YXJ0RHJhZ1glM0IlMjBwYW5ZJTIwJTNEJTIwZS50b3VjaGVzJTVCMCU1RC5jbGllbnRZJTIwLSUyMHN0YXJ0RHJhZ1klM0IlMjB1cGRhdGVUcmFuc2Zvcm0lMjglMjklM0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlN0QlMkMlMjAlN0JwYXNzaXZlJTNBJTIwZmFsc2UlN0QlMjklM0IlMEElMEElMjAlMjAlMjAlMjBjb21wQ29udGFpbmVyLmFkZEV2ZW50TGlzdGVuZXIlMjglMjd0b3VjaGVuZCUyNyUyQyUyMCUyOGUlMjklMjAlM0QlM0UlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjBpZiUyMCUyOGUudG91Y2hlcy5sZW5ndGglMjAlM0MlMjAyJTI5JTIwaXNQaW5jaGluZyUyMCUzRCUyMGZhbHNlJTNCJTIwaWYlMjAlMjhlLnRvdWNoZXMubGVuZ3RoJTIwJTNEJTNEJTNEJTIwMCUyOSUyMGlzRHJhZ2dpbmdJbWclMjAlM0QlMjBmYWxzZSUzQiUwQSUyMCUyMCUyMCUyMCU3RCUyOSUzQiUwQSUwQSU3RCUyOSUyOCUyOSUzQg==";
    var _0x3c4d = document.createElement('script');
    _0x3c4d.innerHTML = decodeURIComponent(atob(_0x1a2b));
    document.body.appendChild(_0x3c4d);
})();
</script>
</body>
</html>
