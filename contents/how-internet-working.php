<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>How the Internet Works — Deep Dive</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; padding: 24px; }
  h1 { text-align: center; font-size: 1.8rem; margin-bottom: 6px; color: #38bdf8; }
  .subtitle { text-align: center; color: #94a3b8; margin-bottom: 32px; font-size: 0.95rem; }

  .tabs { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-bottom: 28px; }
  .tab { padding: 8px 18px; border-radius: 99px; border: 1.5px solid #334155; background: transparent; color: #94a3b8; cursor: pointer; font-size: 0.9rem; transition: all 0.2s; }
  .tab:hover { border-color: #38bdf8; color: #38bdf8; }
  .tab.active { background: #38bdf8; border-color: #38bdf8; color: #0f172a; font-weight: 700; }

  .panel { display: none; }
  .panel.active { display: block; }

  .card { background: #1e293b; border-radius: 16px; padding: 28px; margin-bottom: 20px; border: 1px solid #334155; }
  .card h2 { font-size: 1.2rem; color: #38bdf8; margin-bottom: 12px; }
  .card p { color: #cbd5e1; line-height: 1.7; margin-bottom: 10px; }
  .card p:last-child { margin-bottom: 0; }

  /* Journey animation */
  .journey { display: flex; align-items: center; flex-wrap: wrap; gap: 0; justify-content: center; margin: 24px 0; }
  .node { background: #0f172a; border: 2px solid #38bdf8; border-radius: 12px; padding: 12px 16px; text-align: center; font-size: 0.8rem; color: #e2e8f0; min-width: 90px; position: relative; cursor: pointer; transition: all 0.2s; }
  .node:hover, .node.lit { background: #1e3a5f; border-color: #7dd3fc; box-shadow: 0 0 16px #38bdf855; }
  .node .icon { font-size: 1.5rem; display: block; margin-bottom: 4px; }
  .arrow { color: #475569; font-size: 1.4rem; padding: 0 4px; }
  .tooltip { display: none; position: absolute; bottom: calc(100% + 10px); left: 50%; transform: translateX(-50%); background: #334155; color: #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 0.78rem; width: 200px; line-height: 1.5; z-index: 10; border: 1px solid #475569; }
  .node:hover .tooltip { display: block; }

  /* Layers */
  .layers { display: flex; flex-direction: column; gap: 10px; margin-top: 16px; }
  .layer { border-radius: 10px; padding: 14px 18px; cursor: pointer; transition: all 0.2s; }
  .layer:hover { filter: brightness(1.15); }
  .layer h3 { font-size: 0.95rem; font-weight: 700; }
  .layer p { font-size: 0.82rem; margin-top: 4px; opacity: 0.85; }
  .layer .detail { display: none; margin-top: 8px; font-size: 0.82rem; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 8px; }
  .layer.open .detail { display: block; }

  /* DNS demo */
  .dns-demo { background: #0f172a; border-radius: 12px; padding: 20px; margin-top: 16px; }
  .dns-step { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 14px; opacity: 0.35; transition: opacity 0.4s; }
  .dns-step.active { opacity: 1; }
  .step-num { background: #38bdf8; color: #0f172a; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0; }
  .step-text strong { color: #7dd3fc; display: block; font-size: 0.85rem; }
  .step-text span { color: #94a3b8; font-size: 0.8rem; }
  .dns-btn { margin-top: 10px; padding: 8px 20px; background: #38bdf8; color: #0f172a; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem; }
  .dns-btn:hover { background: #7dd3fc; }

  /* TCP/IP */
  .packet { background: #0f172a; border: 1.5px solid #334155; border-radius: 8px; padding: 10px 14px; margin-bottom: 8px; font-size: 0.82rem; color: #94a3b8; display: flex; gap: 10px; align-items: center; }
  .packet .badge { padding: 2px 10px; border-radius: 99px; font-size: 0.72rem; font-weight: 700; flex-shrink: 0; }
  .badge.ip { background: #7c3aed; color: #fff; }
  .badge.tcp { background: #0369a1; color: #fff; }
  .badge.http { background: #065f46; color: #fff; }
  .badge.tls { background: #92400e; color: #fff; }

  /* Security */
  .lock-demo { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
  .lock-box { flex: 1; min-width: 140px; background: #0f172a; border-radius: 10px; padding: 14px; text-align: center; border: 1.5px solid #334155; }
  .lock-box .icon { font-size: 2rem; margin-bottom: 6px; }
  .lock-box h4 { font-size: 0.85rem; color: #e2e8f0; margin-bottom: 4px; }
  .lock-box p { font-size: 0.75rem; color: #64748b; }

  @media(max-width: 600px) { .journey { flex-direction: column; align-items: center; } .arrow { transform: rotate(90deg); } }
</style>
</head>
<body>

<h1>🌐 How the Internet Works</h1>
<p class="subtitle">Click each section to explore — go as deep as you want.</p>

<div class="tabs">
  <button class="tab active" onclick="showPanel('journey')">📦 A Request's Journey</button>
  <button class="tab" onclick="showPanel('dns')">🔍 DNS Lookup</button>
  <button class="tab" onclick="showPanel('layers')">🧱 Protocol Layers</button>
  <button class="tab" onclick="showPanel('security')">🔒 Security (TLS/HTTPS)</button>
</div>

<!-- PANEL 1: Journey -->
<div class="panel active" id="panel-journey">
  <div class="card">
    <h2>What happens when you type a URL and hit Enter?</h2>
    <p>Your browser kicks off a chain of events involving your device, multiple servers, and a global network of routers — all in under a second. Hover each step to learn what's happening.</p>
    <div class="journey">
      <div class="node" id="n1"><span class="icon">💻</span>Your Browser<div class="tooltip">You type "google.com". The browser needs to find its IP address and fetch the page.</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n2"><span class="icon">📖</span>DNS Lookup<div class="tooltip">Domain Name System translates "google.com" into an IP address like 142.250.80.46.</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n3"><span class="icon">🤝</span>TCP Handshake<div class="tooltip">Your device and the server exchange SYN → SYN-ACK → ACK packets to open a reliable connection.</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n4"><span class="icon">🔐</span>TLS Handshake<div class="tooltip">For HTTPS sites, keys are exchanged so all data is encrypted. Nobody snooping can read it.</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n5"><span class="icon">📤</span>HTTP Request<div class="tooltip">Browser sends "GET / HTTP/2" — essentially asking: "Give me the homepage."</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n6"><span class="icon">🖥️</span>Web Server<div class="tooltip">The server at that IP processes your request, possibly querying a database, and sends back HTML.</div></div>
      <div class="arrow">→</div>
      <div class="node" id="n7"><span class="icon">🎨</span>Render Page<div class="tooltip">Your browser reads the HTML, fetches CSS/JS/images, and paints the page you see.</div></div>
    </div>
    <p style="text-align:center; color:#475569; font-size:0.8rem;">⬆ Hover each node for details</p>
  </div>
</div>

<!-- PANEL 2: DNS -->
<div class="panel" id="panel-dns">
  <div class="card">
    <h2>🔍 How DNS Resolution Actually Works</h2>
    <p>DNS is the internet's phone book — but it's more like a layered treasure hunt. Click "Animate" to walk through a real DNS lookup for <strong style="color:#38bdf8">example.com</strong>.</p>
    <div class="dns-demo">
      <div class="dns-step active" id="ds0">
        <div class="step-num">1</div>
        <div class="step-text"><strong>Browser Cache</strong><span>Browser checks: "Do I already know example.com's IP?" If yes, done. If no, ask the OS.</span></div>
      </div>
      <div class="dns-step" id="ds1">
        <div class="step-num">2</div>
        <div class="step-text"><strong>OS / Resolver Cache</strong><span>The OS checks its own cache and your router. Still no answer? Ask a Recursive Resolver (usually your ISP's).</span></div>
      </div>
      <div class="dns-step" id="ds2">
        <div class="step-num">3</div>
        <div class="step-text"><strong>Root Name Server</strong><span>The resolver asks a Root Server: "Who handles .com domains?" There are only 13 root server clusters worldwide.</span></div>
      </div>
      <div class="dns-step" id="ds3">
        <div class="step-num">4</div>
        <div class="step-text"><strong>TLD Name Server</strong><span>The .com TLD server says: "For example.com, go ask this authoritative name server."</span></div>
      </div>
      <div class="dns-step" id="ds4">
        <div class="step-num">5</div>
        <div class="step-text"><strong>Authoritative Name Server</strong><span>Finally! This server knows the actual IP: "93.184.216.34". The resolver returns it to your browser and caches it.</span></div>
      </div>
      <button class="dns-btn" onclick="animateDNS()">▶ Animate Lookup</button>
    </div>
  </div>
</div>

<!-- PANEL 3: Layers -->
<div class="panel" id="panel-layers">
  <div class="card">
    <h2>🧱 The Protocol Stack — What Wraps What</h2>
    <p>Data doesn't travel raw — it's wrapped in multiple layers of protocol headers, like envelopes inside envelopes. Click each layer to expand it.</p>
    <div class="layers">
      <div class="layer" style="background:#1e3a5f; border-left: 4px solid #38bdf8;" onclick="toggleLayer(this)">
        <h3>Application Layer — HTTP / HTTPS</h3>
        <p>What your app actually says ("GET /page")</p>
        <div class="detail">HTTP defines how browsers and servers talk. HTTP/2 added multiplexing (multiple requests on one connection). HTTP/3 uses UDP via QUIC for speed. HTTPS = HTTP + TLS encryption.</div>
      </div>
      <div class="layer" style="background:#1e3b3b; border-left: 4px solid #10b981;" onclick="toggleLayer(this)">
        <h3>Transport Layer — TCP / UDP</h3>
        <p>Reliability, ordering, and flow control</p>
        <div class="detail">TCP guarantees delivery and order via acknowledgments — great for web pages. UDP skips guarantees for speed — great for video calls and gaming. Every packet gets a source/destination port number here (e.g., port 443 for HTTPS).</div>
      </div>
      <div class="layer" style="background:#2d1e3f; border-left: 4px solid #a78bfa;" onclick="toggleLayer(this)">
        <h3>Internet Layer — IP</h3>
        <p>Routing packets across the globe</p>
        <div class="detail">IP assigns source and destination addresses. Routers read only this layer to decide where to send the packet next. IPv4 uses 32-bit addresses (4.3B total). IPv6 uses 128-bit addresses — practically unlimited.</div>
      </div>
      <div class="layer" style="background:#3b2a1e; border-left: 4px solid #f59e0b;" onclick="toggleLayer(this)">
        <h3>Link Layer — Ethernet / Wi-Fi</h3>
        <p>Physical transmission on your local network</p>
        <div class="detail">This layer handles MAC addresses, which are hardware IDs on your local network. Wi-Fi and Ethernet operate here. Data is converted to actual electrical signals, light pulses (fiber), or radio waves.</div>
      </div>
    </div>
    <div style="margin-top:20px;">
      <p style="color:#64748b; font-size:0.82rem;">A real outgoing packet looks like this (outermost to innermost):</p>
      <div style="margin-top:10px;">
        <div class="packet"><span class="badge ip">IP</span> Src: 192.168.1.5 → Dst: 93.184.216.34 | TTL: 64 | Protocol: TCP</div>
        <div class="packet"><span class="badge tcp">TCP</span> Src Port: 54321 → Dst Port: 443 | Seq: 1001 | ACK: 500 | Flags: PSH</div>
        <div class="packet"><span class="badge tls">TLS</span> Record Type: Application Data | Version: 1.3 | Encrypted payload →</div>
        <div class="packet"><span class="badge http">HTTP</span> GET /index.html HTTP/2 | Host: example.com | Accept: text/html</div>
      </div>
    </div>
  </div>
</div>

<!-- PANEL 4: Security -->
<div class="panel" id="panel-security">
  <div class="card">
    <h2>🔒 How HTTPS & TLS Keep You Safe</h2>
    <p>When you see the padlock in your browser, TLS (Transport Layer Security) is working. It solves three hard problems simultaneously.</p>
    <div class="lock-demo">
      <div class="lock-box">
        <div class="icon">🔏</div>
        <h4>Encryption</h4>
        <p>Data is scrambled so even if intercepted, it's unreadable without the session key.</p>
      </div>
      <div class="lock-box">
        <div class="icon">✅</div>
        <h4>Authentication</h4>
        <p>A Certificate Authority (CA) verifies the server is really who it claims to be.</p>
      </div>
      <div class="lock-box">
        <div class="icon">🛡️</div>
        <h4>Integrity</h4>
        <p>A message authentication code (MAC) ensures data wasn't altered in transit.</p>
      </div>
    </div>
    <div style="margin-top:24px;">
      <h2>The TLS 1.3 Handshake (Simplified)</h2>
      <p style="margin-top:8px;">TLS 1.3 reduced the handshake to just <strong style="color:#38bdf8">1 round-trip</strong> (down from 2 in TLS 1.2), shaving precious milliseconds.</p>
      <div class="dns-demo" style="margin-top:14px;">
        <div class="dns-step active"><div class="step-num">1</div><div class="step-text"><strong>Client Hello</strong><span>Your browser sends supported cipher suites, a random number, and its key share (Diffie-Hellman public key).</span></div></div>
        <div class="dns-step active"><div class="step-num">2</div><div class="step-text"><strong>Server Hello + Certificate</strong><span>Server picks a cipher, sends its key share, and its TLS certificate (signed by a CA your OS trusts).</span></div></div>
        <div class="dns-step active"><div class="step-num">3</div><div class="step-text"><strong>Key Derivation</strong><span>Both sides compute the same shared secret using Diffie-Hellman math — without ever sending the secret over the wire.</span></div></div>
        <div class="dns-step active"><div class="step-num">4</div><div class="step-text"><strong>Encrypted Traffic Begins</strong><span>All further communication is encrypted with AES-256 or ChaCha20. The handshake is complete.</span></div></div>
      </div>
    </div>
  </div>
</div>

<script>
  function showPanel(name) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    event.target.classList.add('active');
  }

  function toggleLayer(el) {
    el.classList.toggle('open');
  }

  let dnsRunning = false;
  function animateDNS() {
    if (dnsRunning) return;
    dnsRunning = true;
    const steps = document.querySelectorAll('.dns-step');
    steps.forEach(s => s.classList.remove('active'));
    let i = 0;
    const interval = setInterval(() => {
      if (i < steps.length) {
        steps[i].classList.add('active');
        i++;
      } else {
        clearInterval(interval);
        dnsRunning = false;
      }
    }, 700);
  }
</script>
</body>
</html>