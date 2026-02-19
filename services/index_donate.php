<div id="donationBtn" class="floating-btn" onclick="toggleDonationModal()">
    <span class="coffee-icon">☕</span>
    <span class="btn-text">เลี้ยงกาแฟทีมงาน</span>
</div>

<div id="donationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="toggleDonationModal()">&times;</span>
        <h2>ขอบคุณที่สนับสนุนเราจ้า! 💖</h2>
        <p>เงินสนับสนุนจะนำไปสร้างบทเรียนสนุกๆ ให้เด็กๆ ต่อไปครับ</p>
        <div class="qr-placeholder">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=YOUR_PROMPTPAY_ID" alt="QR Code">
            <p>สแกนเพื่อโดเนทผ่าน PromptPay</p>
        </div>
    </div>
</div>

<style>
    /* สไตล์ปุ่มลอย */
    .floating-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #ff813f; /* สีส้มกาแฟ */
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        z-index: 999;
        transition: transform 0.3s, background 0.3;
    }
    .floating-btn:hover { transform: scale(1.1); background: #ff9f68; }
    .coffee-icon { font-size: 1.5rem; margin-right: 8px; }
    .btn-text { font-family: 'Itim', cursive; font-size: 1rem; }

    /* สไตล์หน้าต่าง Pop-up */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
        background: white;
        margin: 15% auto;
        padding: 20px;
        width: 80%;
        max-width: 400px;
        border-radius: 20px;
        text-align: center;
        font-family: 'Itim', cursive;
    }
    .qr-placeholder img { width: 200px; margin: 10px 0; }
    .close { float: right; font-size: 28px; cursor: pointer; }
</style>

<script>
    function toggleDonationModal() {
        const modal = document.getElementById('donationModal');
        modal.style.display = (modal.style.display === 'block') ? 'none' : 'block';
    }
</script>