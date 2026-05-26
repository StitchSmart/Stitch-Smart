<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 <title><?=$webname ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/navbar.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/footer.css?v=1.5" rel="stylesheet">
   <link href="<?= BASE_URL ?>/css/design.css" rel="stylesheet">
   <link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

<style>
/* THEME-AWARE DESIGN SELECTION CARD DESIGN */
#home h2 {
    color: var(--text-main, #3d241c) !important;
    font-family: var(--font-headings, 'Playfair Display'), 'Outfit', serif !important;
}

.card {
    background: var(--bg-card, #ffffff) !important; /* Pure white card for light theme, dark for luxury */
    border: 1px solid var(--border-color, rgba(193, 154, 78, 0.15)) !important;
    border-radius: 20px !important;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.03) !important;
}

.card:hover {
    background: var(--bg-card, #ffffff) !important;
    border-color: var(--accent-bronze, #CD9A48) !important;
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(193, 154, 78, 0.1) !important;
}

.card-title {
    color: var(--text-main, #3d241c) !important; /* Dark brown in light theme, white in luxury */
    font-family: var(--font-headings, 'Playfair Display'), 'Outfit', serif !important;
    font-size: 1.45rem !important;
    font-weight: 800 !important;
    margin-bottom: 12px !important;
}

.card-desc {
    color: var(--text-muted, #5c3c26) !important; /* Muted brown in light theme, light in luxury */
    font-size: 0.92rem !important;
    line-height: 1.5 !important;
}

.card img {
    filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
    transition: transform 0.4s ease;
}
</style>
</head>
<body>

<?php $hide_announcement = true; include('header.php'); ?>

  <div class="container">

    <!-- Selection / Home Page -->
    <div id="home" class="page active">
      <h2>What would you like to design?</h2>
      <div class="grid" id="clothing-grid"></div>
    </div>

    <!-- Hoodie Page -->
    <div id="hoodie" class="page">
      <div class="design-page">
        <h1>Design Your Custom Cloths</h1>
        <p>Fit, fabric, color, labels, sunfade, distressing, quantity</p>
        <a  href="<?= BASE_URL; ?>/index.php?page=hoodie" >
        <iframe 
          src="<?= BASE_URL; ?>/index.php?page=hoodie" 
          style="width: 100%; height: 85vh; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
          allowfullscreen
        ></iframe>
</a>
        <button class="back-btn" onclick="navigateTo('')">← Back to Selection</button>
      </div>
    </div>

    <!-- Crewneck Page -->
    <div id="crewneck" class="page">
      <div class="design-page">
        <h1>Design Your Custom Crewneck Sweatshirt</h1>
        <p>Fit, fabric, color, labels, sunfade, distressing, quantity</p>
        
        <iframe 
          src="<?= BASE_URL; ?>/index.php?page=crewneck" 
          style="width: 100%; height: 85vh; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
          allowfullscreen
        ></iframe>
        
        <button class="back-btn" onclick="navigateTo('')">← Back to Selection</button>
      </div>
    </div>

    <!-- Sweatpants Page -->
<div id="sweatpants" class="page">
  <div class="design-page">
    <h1>Design Your Custom Sweatpants</h1>
    <p>Straight leg ya baggy fit, pockets, labels, distressing </p>
    
    <iframe 
      src="<?= BASE_URL; ?>/index.php?page=sweatpant" 
      style="width: 100%; height: 85vh; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
      allowfullscreen
    ></iframe>
    
    <button class="back-btn" onclick="navigateTo('')">← Back to Selection</button>
  </div>
</div>

<!-- Shorts Page -->
<div id="shorts" class="page">
  <div class="design-page">
    <h1>Design Your Custom Shorts</h1>
    <p>Length, fit, pockets, elastic, custom prints and labels</p>
    
    <iframe 
      src="<?= BASE_URL; ?>/index.php?page=shorts" " 
      style="width: 100%; height: 85vh; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
      allowfullscreen
    ></iframe>
    
    <button class="back-btn" onclick="navigateTo('')">← Back to Selection</button>
  </div>
</div>

  </div>

  <script>
    function navigateTo(pageId) {
      document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
      });
      if (pageId) {
        document.getElementById(pageId).classList.add('active');
      } else {
        document.getElementById('home').classList.add('active');
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const grid = document.getElementById('clothing-grid');
      const items = [
        { id: 'hoodie', title: 'Hoodie', img: '<?= BASE_URL ?>/pictures/design/empty_hoodie.png', desc: 'Premium hoodies with full customization' },
        { id: 'crewneck', title: 'Crewneck Sweatshirt', img: '<?= BASE_URL ?>/pictures/design/empty_crewneck.png', desc: 'Cozy crewnecks with prints & finishing' },
        { id: 'sweatpants', title: 'Sweatpants', img: '<?= BASE_URL ?>/pictures/design/empty_pants.png', desc: 'Custom joggers & straight leg' },
        { id: 'shorts', title: 'Shorts', img: '<?= BASE_URL ?>/pictures/design/shorts.png', desc: 'Custom length & styles' }
      ];

      const currentTheme = "<?= $global_theme ?? 'theme-default' ?>";

      items.forEach(item => {
        const card = document.createElement('div');
        card.className = 'card';
        
        let filterStr = '';
        if (currentTheme === 'theme-luxury') {
          // Dark theme: We want crisp white outline line art.
          // Hoodie, crewneck, sweatpants are natively black line art, so we invert them.
          // Shorts is natively a white line art image, so we do NOT invert it.
          if (item.id !== 'shorts') {
            filterStr = 'filter: invert(1) drop-shadow(0 5px 15px rgba(255,255,255,0.15));';
          } else {
            filterStr = 'filter: drop-shadow(0 5px 15px rgba(255,255,255,0.15));';
          }
        } else {
          // Light theme: We want elegant dark-coffee/black outline line art.
          // Hoodie, crewneck, sweatpants are natively black line art, so we do NOT invert them.
          // Shorts is natively a white line art image, so we INVERT it to make it black and turn its white glow into a dark shadow.
          if (item.id === 'shorts') {
            filterStr = 'filter: invert(1) contrast(1.2) drop-shadow(0 3px 8px rgba(0,0,0,0.06));';
          } else {
            filterStr = 'filter: drop-shadow(0 3px 8px rgba(0,0,0,0.06));';
          }
        }

        const imgStyle = `style="${filterStr}"`;

        card.innerHTML = `
          <div class="card-content" onclick="navigateTo('${item.id}')">
            <img src="${item.img}" alt="${item.title}" ${imgStyle}>
            <div class="card-title">${item.title}</div>
            <div class="card-desc">${item.desc}</div>
          </div>
        `;
        grid.appendChild(card);
      });
    });
  </script>
  <?php include('footer.php'); ?>
</body>
</html>