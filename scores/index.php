<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.C.O.R.E.S. - Student Conduct, Offense Recording, & Evaluation System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- SECURE AUTHENTICATION GATEWAY SCREEN -->
    <div id="authGateway" class="auth-fullscreen-container">
        <div class="auth-card">
            <img src="images/school-logo.png" alt="School Emblem" class="auth-logo">
            <h2>S.C.O.R.E.S. Portal Log In</h2>
            <p class="auth-subtitle">Authorized Guidance & Faculty Terminal Access Only</p>
            
            <form id="loginForm">
                <div class="auth-input-group">
                    <label for="authUsername">Username</label>
                    <input type="text" id="authUsername" placeholder="Enter administrative username..." required>
                </div>
                <div class="auth-input-group">
                    <label for="authPassword">Password</label>
                    <input type="password" id="authPassword" placeholder="Enter secure password..." required>
                </div>
                <button type="submit" class="btn btn-auth">🔓 Authenticate and Enter Terminal</button>
            </form>
            <div class="auth-footer-notice"> Protected by Institutional Data Privacy Protocols & RA 10173 </div>
        </div>
    </div>

    <!-- MAIN APPLICATION WORKSPACE (HIDDEN UNTIL AUTHENTICATED) -->
    <div id="mainWorkspace" class="system-hidden-state">
        <header class="main-header">
            <div class="header-container">
                <img src="images/school-logo.png" alt="School Logo" class="logo school-logo">
                <div class="title-area">
                    <h1>S.C.O.R.E.S. Portal</h1>
                    <p>Student Conduct, Offense Recording, and Evaluation System</p>
                </div>
                <img src="images/department-logo.png" alt="Department Logo" class="logo dept-logo">
            </div>
        </header>

        <main class="dashboard-wrapper">
            <!-- MODULE 1: INCIDENT INTAKE FORM (ADMIN INTERACTION VIEW) -->
            <section class="panel panel-form">
                <h2>📥 Module 1: Incident Intake & Violation Entry</h2>
                <form id="violationForm">
                    <div class="form-group">
                        <label for="studentId">Student ID Number</label>
                        <input type="text" id="studentId" placeholder="e.g., 2024-0002" required>
                    </div>
                    <div class="form-group">
                        <label for="studentName">Student Full Name</label>
                        <input type="text" id="studentName" placeholder="Last Name, First Name, M.I." required>
                    </div>
                    <div class="form-group">
                        <label for="violationType">Violation Severity</label>
                        <select id="violationType" required>
                            <option value="Minor">Minor Offense</option>
                            <option value="Major">Major Offense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Offense Description & Details</label>
                        <textarea id="description" rows="3" placeholder="Provide details, location, and actions..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-submit">🔒 Record & Log Violation</button>
                </form>
            </section>

            <!-- MODULE 2: MULTI-VIOLATION SCANNER (CLIENT EVALUATION VIEW) -->
            <section class="panel panel-scan">
                <h2>🔍 Module 2: Multi-Violation Scanner & Good Moral Evaluation</h2>
                <div class="search-box">
                    <input type="text" id="searchId" placeholder="Scan ID / Type Student ID Number...">
                    <button type="button" id="scanBtn" class="btn btn-search">Scan Student</button>
                </div>
                <div id="scanResultDisplay" class="result-display default-state">
                    <div class="placeholder-text"> <p>Awaiting student lookup or ID scan input...</p> </div>
                </div>
            </section>
        </main>

        <footer class="system-footer">
            <div class="footer-links-container">
                <a href="https://pampangastateu.edu.ph/" target="_blank" class="footer-link-item">🌐 Official Pampanga State U Website</a>
                <a href="https://www.facebook.com/PampangaStateU/" target="_blank" class="footer-link-item">🔵 Official Facebook Page</a>
            </div>
            <p style="margin-top: 15px;">S.C.O.R.E.S. LAN Environment v1.0.0 | Powered by PHP Backend Server Framework</p>
        </footer>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT ENGINE (NETWORK DATA ROUTING) -->
    <!-- ========================================== -->
    <script>
        // Prototype Login Hook Authentication (admin / password123)
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (document.getElementById('authUsername').value === "admin" && document.getElementById('authPassword').value === "password123") {
        document.getElementById('authGateway').style.display = 'none';
        document.getElementById('mainWorkspace').classList.remove('system-hidden-state');
    } else {
        alert("❌ Authentication Failure: Invalid Administrative Credentials.");
    }
});

        // Backend POST Connection: Save New Violation Infraction
        document.getElementById('violationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const studentId = document.getElementById('studentId').value.trim();
            const studentName = document.getElementById('studentName').value.trim();
            const violationType = document.getElementById('violationType').value;
            const description = document.getElementById('description').value.trim();
            const timestamp = new Date().toLocaleString();

            const fetchRes = await fetch('database.php');
            let currentRecords = await fetchRes.json();

            currentRecords.push({ studentId, studentName, violationType, description, timestamp });

            const response = await fetch('database.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(currentRecords)
            });
            
            const result = await response.json();
            if (result.success) {
                alert("Violation successfully registered in XAMPP backend database repository!");
                this.reset();
            }
        });

        // Backend GET Connection: Scan & Perform Multi-Violation Analysis
        document.getElementById('scanBtn').addEventListener('click', performScan);
        document.getElementById('searchId').addEventListener('keypress', function(e) { if (e.key === 'Enter') performScan(); });

        async function performScan() {
            const searchId = document.getElementById('searchId').value.trim();
            const display = document.getElementById('scanResultDisplay');
            if (!searchId) return alert("Please input or scan a Student ID");

            display.className = "result-display";

            const response = await fetch('database.php');
            const allRecords = await response.json();
            const studentRecords = allRecords.filter(r => r.studentId === searchId);

            if (studentRecords.length === 0) {
                display.classList.add('status-green');
                display.innerHTML = `
                    <div class="badge status-badge-clear">✅ CLEAR / APPROVED FOR ISSUANCE</div> 
                    <div class="student-profile-summary"> 
                        <img src="images/default-avatar.png" alt="Profile" class="student-avatar-img"> 
                        <div class="student-meta"> 
                            <h3>Student ID: ${searchId}</h3> 
                            <p><strong>Behavioral Standing:</strong> Pristine Record (0 Incidents)</p> 
                            <p class="status-msg" style="margin-top: 8px; color: var(--text-muted);">This account holds zero records of misconduct. The individual is cleared to receive their Certificate of Good Moral Character.</p> 
                        </div> 
                    </div> 
                    <button onclick="window.print()" class="btn btn-print">🖨️ Print Good Moral Clearance Form</button>
                `;
            } else {
                let studentName = studentRecords[0].studentName;
                let minorCount = studentRecords.filter(r => r.violationType === 'Minor').length;
                let majorCount = studentRecords.filter(r => r.violationType === 'Major').length;
                
                let isBlocked = majorCount > 0 || minorCount >= 3;

                display.className = "result-display " + (isBlocked ? 'status-red' : 'status-yellow');

                let statusBadgeText = isBlocked ? '🛑 ACCOUNT HOLD / BLOCKED' : '⚠️ UNDER ADMINISTRATIVE REVIEW';
                let statusBadgeClass = isBlocked ? 'status-badge-blocked' : 'status-badge-warn';
                let recommendationText = isBlocked 
                    ? 'System Action: Print locking active. Document printing is blocked due to regulations breach.' 
                    : 'System Action: Document generation conditional. Counselor review required before manual clearance bypass.';
                
                let listHtml = studentRecords.map(r => `
                    <div class="violation-card-item severity-${r.violationType.toLowerCase()}"> 
                        <div class="card-meta"><strong>[${r.violationType.toUpperCase()}]</strong> Registered: ${r.timestamp}</div> 
                        <p style="margin: 4px 0 0 0; color: #fff;">${r.description}</p> 
                    </div>
                `).join('');

                display.innerHTML = `
                    <div class="badge ${statusBadgeClass}">${statusBadgeText}</div> 
                    <div class="student-profile-summary"> 
                        <img src="images/default-avatar.png" alt="Profile" class="student-avatar-img"> 
                        <div class="student-meta"> 
                            <h3>${studentName}</h3> <h4>ID: ${searchId}</h4> 
                            <p style="color: #fff; margin-top: 4px;">Active Count: <span style="color: var(--neon-yellow);">${minorCount} Minor</span> | <span style="color: var(--neon-red);">${majorCount} Major</span></p> 
                        </div> 
                    </div> 
                    <div class="offense-log-list"> 
                        <h4 style="margin: 0 0 10px 0; font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Historical Violations Index:</h4>
                        ${listHtml} 
                    </div> 
                    <p class="action-alert-msg" style="font-size: 0.85rem; padding: 10px; background: rgba(0,0,0,0.2); border-radius: 4px;">${recommendationText}</p> 
                    ${isBlocked ? '' : '<button onclick="window.print()" class="btn btn-print">🖨️ Print Conditional Clearance Approval</button>'} 
                    <button onclick="clearRecords('${searchId}')" class="btn btn-clear-data" style="margin-top: 15px; background: #333; color: #ff7675; border: 1px solid #444; font-size: 0.8rem; padding: 8px; cursor:pointer; width:100%; border-radius:4px;">🔧 Administrative Profile Override (Purge Violations)</button>
                `;
            }
        }

        // Backend DELETE Connection: Override and Clear Profile Logs
        async function clearRecords(id) {
            if (confirm("Are you sure you want to permanently clear this student's backend server log history?")) {
                const response = await fetch(`database.php?studentId=${id}`, { method: 'DELETE' });
                const result = await response.json();
                if (result.success) {
                    alert("Records wiped from backend repository server folder.");
                    performScan();
                }
            }
        }
    </script>
</body>
</html>