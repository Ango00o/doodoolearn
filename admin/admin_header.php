<nav class="admin-nav">
    <div class="nav-container">
        <a href="index.php" class="btn-back-home">
            <span class="icon">🏠</span> เมนูหลักผู้ปกครอง
        </a>
        <span class="admin-title">ระบบจัดการหลังบ้าน ⚙️</span>
    </div>
</nav>

<style>
.admin-nav {
    background: #2c3e50;
    padding: 15px 20px;
    margin-bottom: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn-back-home {
    background: #e67e22;
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: bold;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}
.btn-back-home:hover {
    background: #d35400;
    transform: translateX(-5px);
}
.admin-title {
    color: #ecf0f1;
    font-size: 1.2rem;
    font-weight: bold;
}
</style>