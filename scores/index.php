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
                            <option value="Clear">No Violation / Good Standing</option>
                            <option value="Minor">Minor Offense</option>
                            <option value="Major">Major Offense</option>
                        </select>
                    </div>
<div class="form-group">
    <label for="description">Remarks / Details</label>
    <textarea id="description" rows="3" placeholder="Provide event details or status observations (Optional for Good Standing)..."></textarea>
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

        <!-- FOOTER SYSTEM METADATA WITH OFFICIAL LINKS -->
        <footer class="system-footer">
            <div class="footer-links-container">
                <a href="https://pampangastateu.edu.ph" target="_blank" class="footer-link-item">🌐 Official Pampanga State U Website</a>
                <a href="https://www.facebook.com/PampangaStateU/" target="_blank" class="footer-link-item">🔵 Official Facebook Page</a>
            </div>
            <p style="margin-top: 15px;">S.C.O.R.E.S. LAN Environment v1.0.0 | Powered by PHP Backend Server Framework</p>
        </footer>
    </div>
    
   <div id="safetyModal" class="modal-overlay system-hidden-state">
        <div class="modal-box">
            <div class="modal-icon">⚠️</div>
            <h2 class="modal-title">CRITICAL PROFILE CONFLICT</h2>
            <div class="modal-body">
                <p>The Student ID you entered is already linked to an existing profile in the system:</p>
                <div class="data-comparison-container">
                    <div class="data-row"><span class="data-label">Database Record:</span> <strong id="modalDbName" class="data-value highlight-red"></strong></div>
                    <div class="data-row"><span class="data-label">Your New Entry:</span> <strong id="modalInputName" class="data-value highlight-yellow"></strong></div>
                </div>
                <p class="modal-warning-text"><strong>ATTENTION:</strong> Pressing "CONFIRM UPDATE" will overwrite and permanently rename this student's identity across all past server logs.</p>
            </div>
            <div class="modal-actions">
                <button type="button" id="modalCancelBtn" class="btn btn-modal-cancel">❌ Cancel & Review</button>
                <button type="button" id="modalConfirmBtn" class="btn btn-modal-confirm">📝 Confirm Update</button>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <!-- JAVASCRIPT ENGINE (NETWORK DATA ROUTING) -->
    <!-- ========================================== -->
    <script>
        // Prototype Login Hook Authentication (admin / password123)
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
            // 🌟 CONDITIONAL FORM REQUIREMENT LOGIC
            // Enforce description details for offenses, but auto-fill if left blank for Good Standing
            if (!description) {
                if (violationType === "Minor" || violationType === "Major") {
                    alert(`⚠️ INPUT ERROR:\n\nYou must provide descriptive details or actions taken for a registered ${violationType} offense.`);
                    document.getElementById('description').focus();
                    return; // Stops the form from saving
                } else {
                    description = "Student record initialized in clear behavioral standing.";
                }
            }

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
        alert("Data successfully registered in XAMPP backend database repository!");
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

    // Clear out old styling tags dynamically
    display.className = "result-display";

    const response = await fetch('database.php');
    const allRecords = await response.json();
    const studentRecords = allRecords.filter(r => r.studentId === searchId);

    // Calculate active offense counts from server array records
    let minorCount = studentRecords.filter(r => r.violationType === 'Minor').length;
    let majorCount = studentRecords.filter(r => r.violationType === 'Major').length;
    let totalOffenses = minorCount + majorCount;

    let statusBadgeText = "";
    let statusBadgeClass = "";
    let recommendationText = "";

    if (totalOffenses === 0) {
        // LEVEL 1: GREEN STATUS (PASSED)
        let studentName = studentRecords.length > 0 ? studentRecords[0].studentName : "Unregistered Student";
        display.classList.add('status-green');
        display.innerHTML = `
            <div class="badge status-badge-clear">✅ CLEAR / APPROVED FOR ISSUANCE</div>
            <div class="student-profile-summary">
                <img src="images/default-avatar.png" class="student-avatar-img" alt="Profile">
                <div class="student-meta">
                    <h3>${studentName}</h3><h4>Student ID: ${searchId}</h4>
                    <p><strong>Standing:</strong> Verified Pristine Record (0 Active Incidents)</p>
                </div>
            </div>
            <button onclick="window.print()" class="btn btn-print">🖨️ Print Good Moral Clearance Form</button>`;
        return;
    }

    // EVALUATE PENALTY HIERARCHIES
    if (minorCount >= 5 || majorCount >= 3) {
        // LEVEL 4: CRITICAL EXPULSION HOLD (HABITUAL OFFENDER)
        display.classList.add('status-red');
        statusBadgeText = "🛑 CRITICAL HOLD: HABITUAL OFFENDER";
        statusBadgeClass = "status-badge-blocked";
        recommendationText = `System Action: Critical Lockout Active. This individual has accumulated an extreme frequency of infractions (${minorCount} Minor, ${majorCount} Major). Profile escalated directly to the Student Disciplinary Board for structural suspension review.`;
    } else if (minorCount >= 3 || majorCount > 0) {
        // LEVEL 3: STANDARD DISCIPLINARY HOLD
        display.classList.add('status-red');
        statusBadgeText = "🛑 ACCOUNT HOLD / BLOCKED";
        statusBadgeClass = "status-badge-blocked";
        recommendationText = `System Action: Print locking active. Document printing is heavily restricted due to uncompleted community service, recurring issues, or an active Major incident file.`;
    } else {
        // LEVEL 2: CONDITIONAL WARNING
        display.classList.add('status-yellow');
        statusBadgeText = "⚠️ UNDER ADMINISTRATIVE REVIEW";
        statusBadgeClass = "status-badge-warn";
        recommendationText = `System Action: Document generation conditional. Student has active minor offenses on file. Guidance Counselor verification required before executing a manual print override.`;
    }

    // Render out the dynamic historical card logs list cleanly
    let studentName = studentRecords[0].studentName;
    let listHtml = studentRecords.map(r => `
        <div class="violation-card-item severity-${r.violationType.toLowerCase()}">
            <div class="card-meta"><strong>[${r.violationType.toUpperCase()}]</strong> Logged: ${r.timestamp}</div>
            <p style="margin: 4px 0 0 0; color: #fff;">${r.description}</p>
        </div>`).join('');

    display.innerHTML = `
        <div class="badge ${statusBadgeClass}">${statusBadgeText}</div>
        <div class="student-profile-summary">
            <img src="images/default-avatar.png" class="student-avatar-img" alt="Profile">
            <div class="student-meta">
                <h3>${studentName}</h3><h4>ID: ${searchId}</h4>
                <p style="color: #fff; margin-top: 4px;">Active Ledger: <span style="color: var(--neon-yellow);">${minorCount} Minor</span> | <span style="color: var(--neon-red);">${majorCount} Major</span></p>
            </div>
        </div>
        <div class="offense-log-list">
            <h4 style="margin: 0 0 10px 0; font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Historical Violations Index:</h4>
            ${listHtml}
        </div>
        <p class="action-alert-msg" style="font-size: 0.85rem; padding: 10px; background: rgba(0,0,0,0.2); border-radius: 4px;">${recommendationText}</p>
        ${(minorCount >= 3 || majorCount > 0) ? '' : '<button onclick="window.print()" class="btn btn-print">🖨️ Print Conditional Clearance Approval</button>'}
        <button onclick="clearRecords('${searchId}')" class="btn btn-clear-data" style="margin-top: 15px; background: #333; color: #ff7675; border: 1px solid #444; font-size: 0.8rem; padding: 8px; cursor:pointer; width:100%; border-radius:4px;">🔧 Administrative Profile Override (Purge Violations)</button>`;
}

async function clearRecords(id) {
    // 🌟 FEATURE 1: SECURE DOUBLE-CONFIRMATION PROMPT
    if (confirm(`⚠️ CRITICAL OVERRIDE: Are you sure you want to permanently clear the disciplinary history logs for Student ID: ${id}?`)) {
        
        // Grab the existing collection from the server
        const response = await fetch('database.php');
        const allRecords = await response.json();
        
        // Find the student's name from their current active records
        const targetStudent = allRecords.find(r => r.studentId === id);
        const savedName = targetStudent ? targetStudent.studentName : "Student Record";

        // Filter out old Minor/Major records, but keep other accounts untouched
        let updatedRecords = allRecords.filter(r => r.studentId !== id);

        // 🌟 FEATURE 2: PRESERVE PROFILE DATA
        // Push a single clean baseline entry so the ID and Name are retained on the server
        updatedRecords.push({
            studentId: id,
            studentName: savedName,
            violationType: "Clear",
            description: "Disciplinary archive records purged via Administrative Profile Override.",
            timestamp: new Date().toLocaleString()
        });

        // Save the cleaned dataset array back to database.json
        const saveResponse = await fetch('database.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedRecords)
        });

        const result = await saveResponse.json();
        if (result.success) {
            alert(`✅ Administrative Override Successful! Disciplinary profile reset to Good Standing for ${savedName}.`);
            performScan(); // Instantly refresh the screen view state
        }
    }
}
// Backend POST Connection: Save New Violation Infraction with Security Validation
document.getElementById('violationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const studentId = document.getElementById('studentId').value.trim();
    const studentName = document.getElementById('studentName').value.trim();
    const violationType = document.getElementById('violationType').value;
    const description = document.getElementById('description').value.trim();
    const timestamp = new Date().toLocaleString();

    // 📡 Step 1: Query the server database before allowing submission
    const fetchRes = await fetch('database.php');
    let currentRecords = await fetchRes.json();

    // 🔍 Step 2: Search if this Student ID already exists anywhere in the system
    const existingStudent = currentRecords.find(r => r.studentId === studentId);
            if (existingStudent) {
                if (existingStudent.studentName.toLowerCase() !== studentName.toLowerCase()) {
                    
                    const confirmCorrection = confirm(`⚠️ TYPO / NAME MISMATCH DETECTED:\n\nStudent ID "${studentId}" is currently saved as "${existingStudent.studentName}" in the database.\n\nYou typed: "${studentName}".\n\nDo you want to CORRECT and UPDATE this student's name across all records on the server?`);
                    
                    if (confirmCorrection) {
                        // Dynamically update the name on every single historical card log matching this ID
                        currentRecords.forEach(record => {
                            if (record.studentId === studentId) {
                                record.studentName = studentName;
                            }
                        });
                        alert(`📝 Profile updated! The name has been corrected to "${studentName}" across all backend server logs.`);
                    } else {
                        // If they click cancel, abort the submission entirely
                        document.getElementById('studentName').focus();
                        return;
                    }
                }
            }

    // 💾 If it's a completely brand new student OR the name matches perfectly, proceed to save:
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


</script>
</body>
</html>