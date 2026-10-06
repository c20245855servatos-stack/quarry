<?php
/**
 * Reusable Address Selector — Negros Occidental (Bacolod to Victorias)
 * Call: renderAddressSelector('address', $currentValue, '', true)
 */
function renderAddressSelector(
    string $fieldName = 'address',
    string $currentValue = '',
    string $inputClass = '',
    bool $required = false
): void {
    $cities = [
        'Bacolod City' => [
            'Barangay 1','Barangay 2','Barangay 3','Barangay 4','Barangay 5',
            'Barangay 6','Barangay 7','Barangay 8','Barangay 9','Barangay 10',
            'Barangay 11','Barangay 12','Barangay 13','Barangay 14','Barangay 15',
            'Barangay 16','Barangay 17','Barangay 18','Barangay 19','Barangay 20',
            'Barangay 21','Barangay 22','Barangay 23','Barangay 24','Barangay 25',
            'Barangay 26','Barangay 27','Barangay 28','Barangay 29','Barangay 30',
            'Barangay 31','Barangay 32','Barangay 33','Barangay 34','Barangay 35',
            'Barangay 36','Barangay 37','Barangay 38','Barangay 39','Barangay 40',
            'Barangay 41',
            'Alangilan','Alijis','Banago','Bata','Cabug','Estefania','Felisa',
            'Granada','Handumanan','Mandalagan','Mansilingan','Montevista',
            'Pahanocoy','Punta Taytay','Singcang-Airport','Sum-ag','Taculing',
            'Tangub','Villamonte','Vista Alegre',
        ],
        'Talisay City' => [
            'Bubog','Cabatangan','Concepcion','Dos Hermanas','Efigenio Lizares',
            'Katilingban','Matab-ang','San Fernando',
            'Zone 1 (Poblacion)','Zone 2 (Poblacion)','Zone 3 (Poblacion)',
            'Zone 4 (Poblacion)','Zone 4-A (Poblacion)','Zone 5 (Poblacion)',
            'Zone 6 (Poblacion)','Zone 7 (Poblacion)','Zone 8 (Poblacion)',
            'Zone 9 (Poblacion)','Zone 10 (Poblacion)','Zone 11 (Poblacion)',
            'Zone 12 (Poblacion)','Zone 12-A (Poblacion)','Zone 14 (Poblacion)',
            'Zone 14-A (Poblacion)','Zone 14-B (Poblacion)','Zone 15 (Poblacion)',
            'Zone 16 (Poblacion)',
        ],
        'Silay City' => [
            'Balaring',
            'Barangay I (Poblacion)','Barangay II (Poblacion)','Barangay III (Poblacion)',
            'Barangay IV (Poblacion)','Barangay V (Poblacion)','Barangay VI (Poblacion/Hawaiian)',
            'Bagtic','Eustaquio Lopez','Guimbala-on','Guinhalaran',
            'Kapitan Ramon','Lantad','Mambulac','Patag','Rizal',
        ],
        'E.B. Magalona' => [
            'Alacaygan','Alicante','Batea','Canlusong','Consing','Cudangdang',
            'Damgo','Gahit','Latasan','Madalag','Manta-angan','Nanca','Pasil',
            'Poblacion 1','Poblacion 2','Poblacion 3','San Isidro','San Jose','Santo Niño',
            'Tabigue','Tanza','Tomongtong','Tuburan',
        ],
        'Victorias City' => [
            'Barangay I (Poblacion)','Barangay II (Poblacion)','Barangay III (Poblacion)',
            'Barangay IV (Poblacion)','Barangay V (Poblacion)','Barangay VI (Poblacion)',
            'Barangay VI-A','Barangay VII (Poblacion)','Barangay VIII',
            'Barangay IX (Daan Banwa)','Barangay X (Estado)','Barangay XI (Gawahon)',
            'Barangay XII','Barangay XIII','Barangay XIV','Barangay XV',
            'Barangay XV-A','Barangay XVI','Barangay XVI-A','Barangay XVII',
            'Barangay XVIII','Barangay XVIII-A','Barangay XIXX',
            'Barangay XIX-A (Canetown Subdivision)','Barangay XX','Barangay XXI',
        ],
    ];

    $uid = 'addr_' . substr(md5($fieldName . uniqid('', true)), 0, 6);
    $req = $required ? 'required' : '';
    $citiesJson = json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<div id="<?= $uid ?>_wrap">
<style>
#<?= $uid ?>_wrap select,
#<?= $uid ?>_wrap input[type="text"] {
  width:100%; padding:10px 13px;
  background:rgba(0,0,0,0.3);
  border:1px solid rgba(255,255,255,0.12);
  border-radius:7px; color:#fff;
  font-size:0.88rem; font-weight:600;
  margin-bottom:10px;
  transition:border-color .2s,box-shadow .2s;
  -webkit-appearance:none; appearance:none;
  box-sizing:border-box;
}
#<?= $uid ?>_wrap select {
  background-color:rgba(0,0,0,0.3);
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23FFD700' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat; background-position:right 12px center;
  padding-right:36px; cursor:pointer;
}
#<?= $uid ?>_wrap select:focus,
#<?= $uid ?>_wrap input[type="text"]:focus {
  outline:none; border-color:#FFD700;
  box-shadow:0 0 0 3px rgba(255,215,0,0.12);
  background-color:rgba(0,0,0,0.4);
}
#<?= $uid ?>_wrap select option { background:#1a1a1a; color:#fff; }
#<?= $uid ?>_wrap select:disabled { opacity:0.4; cursor:not-allowed; }
#<?= $uid ?>_wrap .ar2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
#<?= $uid ?>_wrap .aro { opacity:0.45; cursor:not-allowed; }
@media(max-width:480px){ #<?= $uid ?>_wrap .ar2 { grid-template-columns:1fr; } }
</style>

<input type="hidden" name="<?= htmlspecialchars($fieldName) ?>"
       id="<?= $uid ?>_h" value="<?= htmlspecialchars($currentValue) ?>" <?= $req ?>>

<!-- Static readonly defaults (top) -->
<input type="text" value="Philippines" readonly class="aro">
<div class="ar2">
  <input type="text" value="Western Visayas" readonly class="aro">
  <input type="text" value="Negros Occidental" readonly class="aro">
</div>

<!-- City -->
<select id="<?= $uid ?>_city" onchange="<?= $uid ?>cc()">
  <option value="">— Select City / Municipality —</option>
  <?php foreach (array_keys($cities) as $city): ?>
  <option value="<?= htmlspecialchars($city) ?>"><?= htmlspecialchars($city) ?></option>
  <?php endforeach; ?>
</select>

<!-- Barangay (populated by JS) -->
<select id="<?= $uid ?>_brgy" onchange="<?= $uid ?>c()" disabled>
  <option value="">— Select Barangay —</option>
</select>

<!-- Street / Building (bottom) -->
<div class="ar2">
  <input type="text" id="<?= $uid ?>_st" placeholder="Street / Road name"
         maxlength="100" oninput="<?= $uid ?>c(); if(typeof stripEmojiField==='function') stripEmojiField(this)">
  <input type="text" id="<?= $uid ?>_bldg" placeholder="House No. / Building (optional)"
         maxlength="80" oninput="<?= $uid ?>c(); if(typeof stripEmojiField==='function') stripEmojiField(this)">
</div>
</div>

<script>
(function(){
  var D=<?= $citiesJson ?>, u='<?= $uid ?>';
  function g(x){return document.getElementById(u+'_'+x);}
  window[u+'cc']=function(){
    var c=g('city').value, b=g('brgy');
    b.innerHTML='<option value="">— Select Barangay —</option>';
    if(c&&D[c]){
      D[c].slice().sort().forEach(function(n){
        var o=document.createElement('option');
        o.value=n; o.textContent=n; b.appendChild(o);
      });
      b.disabled=false;
    } else { b.disabled=true; }
    window[u+'c']();
  };
  window[u+'c']=function(){
    var p=[],bldg=g('bldg').value.trim(),st=g('st').value.trim(),
        br=g('brgy').value,ci=g('city').value;
    if(bldg)p.push(bldg);
    if(st)p.push(st);
    if(br)p.push('Brgy. '+br);
    if(ci)p.push(ci);
    p.push('Negros Occidental','Western Visayas','Philippines');
    g('h').value=p.join(', ');
  };
  // Pre-fill
  (function(){
    var v=g('h').value; if(!v)return;
    Object.keys(D).forEach(function(ci){
      if(v.indexOf(ci)===-1)return;
      g('city').value=ci; window[u+'cc']();
      D[ci].forEach(function(b){ if(v.indexOf('Brgy. '+b)!==-1)g('brgy').value=b; });
      var skip=[ci,'Negros Occidental','Western Visayas','Philippines'];
      var br=D[ci].find(function(b){return v.indexOf('Brgy. '+b)!==-1;});
      if(br)skip.push('Brgy. '+br);
      var rem=v.split(',').map(function(s){return s.trim();})
               .filter(function(s){return skip.indexOf(s)===-1;});
      if(rem[0])g('bldg').value=rem[0];
      if(rem[1])g('st').value=rem[1];
      // Re-compose so hidden field stays in sync
      window[u+'c']();
    });
  })();
})();
</script>
<?php
}
?>
