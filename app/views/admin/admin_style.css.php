<style>
/* ========================
   ADMIN DASHBOARD STYLES - CONSTRUCTION THEME
======================== */

/* CSS Variables */
:root {
  --background: #1a1a1a;
  --text-primary: #ffffff;
  --text-secondary: rgba(255, 255, 255, 0.7);
  --border-color: rgba(255, 255, 255, 0.1);
  --accent-color: #FFD700;
}

/* Admin Wrapper */
.adm-wrap {
  padding: 20px;
  background: var(--background, #1a1a1a);
  color: var(--text-primary, #ffffff);
  min-height: calc(100vh - 60px);
}

/* Page Header */
.adm-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 2px solid #333333;
}

.adm-title {
  font-size: 1.8rem;
  font-weight: 900;
  color: #ffffff;
  margin: 0 0 8px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.adm-sub {
  color: rgba(255, 255, 255, 0.7);
  margin: 0;
  font-size: 0.9rem;
}

.adm-date {
  background: rgba(255, 255, 255, 0.1);
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 700;
  color: #ffffff;
}

/* Stats Cards */
.adm-stats {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 32px;
}

.stat-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  padding: 14px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: 0.3s ease;
  min-width: 0;
  overflow: hidden;
}

.stat-card:hover {
  background: rgba(255, 255, 255, 0.08);
  transform: translateY(-2px);
}

.stat-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  color: #ffffff;
  flex-shrink: 0;
}

.stat-icon.green { background: #22c55e; }
.stat-icon.blue { background: #3b82f6; }
.stat-icon.yellow { background: #eab308; }
.stat-icon.orange { background: #f97316; }

.stat-num {
  font-size: clamp(1rem, 1.4vw, 1.3rem);
  font-weight: 900;
  color: #ffffff;
  line-height: 1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.stat-lbl {
  font-size: 0.7rem;
  color: rgba(255, 255, 255, 0.6);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 700;
}

/* Section Title */
.adm-section-title {
  font-size: 1.1rem;
  font-weight: 900;
  color: #ffffff;
  margin: 32px 0 16px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Quick Actions — removed (unused) */

/* Grid Layout */
.adm-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-bottom: 32px;
}

/* Cards */
.adm-card {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  overflow: hidden;
}

.adm-card-head {
  padding: 16px 20px;
  background: rgba(255, 255, 255, 0.05);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 700;
  color: #ffffff;
}

.adm-link {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  font-size: 0.85rem;
  transition: 0.3s ease;
}

.adm-link:hover {
  color: #ffffff;
}

/* Tables */
.adm-table {
  width: 100%;
  border-collapse: collapse;
}

.adm-table th {
  background: rgba(255, 255, 255, 0.05);
  padding: 12px 16px;
  text-align: left;
  font-size: 0.8rem;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.8);
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.adm-table td {
  padding: 12px 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  font-size: 0.85rem;
  color: #ffffff;
}

.adm-table tr:hover {
  background: rgba(255, 255, 255, 0.03);
}

/* Status Badges */
.status-badge {
  padding: 3px 9px;
  border-radius: 5px;
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

/* Order status — muted rgba style */
.status-pending         { background:rgba(245,158,11,0.15);  border:1px solid rgba(245,158,11,0.4);  color:#fbbf24; }
.status-confirmed       { background:rgba(59,130,246,0.15);  border:1px solid rgba(59,130,246,0.4);  color:#60a5fa; }
.status-processing      { background:rgba(139,92,246,0.15);  border:1px solid rgba(139,92,246,0.4);  color:#a78bfa; }
.status-out_for_delivery{ background:rgba(6,182,212,0.15);   border:1px solid rgba(6,182,212,0.4);   color:#22d3ee; }
.status-completed       { background:rgba(34,197,94,0.15);   border:1px solid rgba(34,197,94,0.4);   color:#4ade80; }
.status-cancelled       { background:rgba(239,68,68,0.15);   border:1px solid rgba(239,68,68,0.4);   color:#f87171; }

/* Material status */
.status-active          { background:rgba(34,197,94,0.15);   border:1px solid rgba(34,197,94,0.4);   color:#4ade80; }
.status-inactive        { background:rgba(107,114,128,0.15); border:1px solid rgba(107,114,128,0.4); color:#9ca3af; }
.status-archived        { background:rgba(107,114,128,0.15); border:1px solid rgba(107,114,128,0.4); color:#9ca3af; }

/* User role */
.status-admin           { background:rgba(255,215,0,0.15);   border:1px solid rgba(255,215,0,0.35);  color:#FFD700; }
.status-member          { background:rgba(59,130,246,0.15);  border:1px solid rgba(59,130,246,0.3);  color:#60a5fa; }

/* Activity Log */
.log-list {
  padding: 16px 20px;
}

.log-item {
  display: flex;
  gap: 12px;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.log-item:last-child {
  margin-bottom: 0;
  padding-bottom: 0;
  border-bottom: none;
}

.log-dot {
  width: 8px;
  height: 8px;
  background: #3b82f6;
  border-radius: 50%;
  margin-top: 6px;
  flex-shrink: 0;
}

.log-action {
  font-weight: 700;
  color: #ffffff;
  font-size: 0.85rem;
}

.log-detail {
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.8rem;
  margin: 2px 0;
}

.log-time {
  color: rgba(255, 255, 255, 0.5);
  font-size: 0.75rem;
}

/* Empty State */
.adm-empty {
  padding: 40px 20px;
  text-align: center;
  color: rgba(255, 255, 255, 0.5);
  font-style: italic;
}

/* Additional Admin Components */
.adm-header-actions {
  display: flex;
  gap: 12px;
  align-items: center;
}

.adm-btn {
  padding: 8px 16px;
  border-radius: 6px;
  border: 1px solid;
  text-decoration: none;
  font-size: 0.85rem;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: 0.3s ease;
  cursor: pointer;
  background: none;
}

.adm-btn-green {
  background: #22c55e;
  border-color: #16a34a;
  color: #ffffff;
}

.adm-btn-green:hover {
  background: #16a34a;
  color: #ffffff;
}

.adm-btn-blue {
  background: #3b82f6;
  border-color: #2563eb;
  color: #ffffff;
}

.adm-btn-blue:hover {
  background: #2563eb;
  color: #ffffff;
}

.adm-btn-yellow {
  background: #eab308;
  border-color: #ca8a04;
  color: #000000;
}

.adm-btn-yellow:hover {
  background: #ca8a04;
  color: #000000;
}

.adm-btn-red {
  background: #ef4444;
  border-color: #dc2626;
  color: #ffffff;
}

.adm-btn-red:hover {
  background: #dc2626;
  color: #ffffff;
}

.adm-btn-gray {
  background: #6b7280;
  border-color: #4b5563;
  color: #ffffff;
}

.adm-btn-gray:hover {
  background: #4b5563;
  color: #ffffff;
}

.adm-btn-teal {
  background: #14b8a6;
  border-color: #0d9488;
  color: #ffffff;
}

.adm-btn-teal:hover {
  background: #0d9488;
  color: #ffffff;
}

.adm-search {
  margin-bottom: 20px;
}

.adm-input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 6px;
  background: rgba(255, 255, 255, 0.05);
  color: #ffffff;
  font-size: 0.9rem;
}

.adm-input:focus {
  outline: none;
  border-color: rgba(255, 255, 255, 0.4);
  background: rgba(255, 255, 255, 0.08);
}

.adm-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

/* Select dropdown specific styling */
.adm-input select,
select.adm-input {
  background: #1a1a1a;
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
  cursor: pointer;
}

.adm-input select:focus,
select.adm-input:focus {
  border-color: #FFD700;
  background: #2d2d2d;
}

.adm-input select option,
select.adm-input option {
  background: #1a1a1a;
  color: #ffffff;
  padding: 8px 12px;
}

.adm-input select option:hover,
select.adm-input option:hover {
  background: #2d2d2d;
}

.adm-input select option:checked,
select.adm-input option:checked {
  background: #FFD700;
  color: #1a1a1a;
}

/* These are now handled by .status-active / .status-inactive / .status-out_for_delivery in the badge block above */

/* Modal Styles */
.adm-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
  transition: 0.3s ease;
}

.adm-modal-overlay.open {
  opacity: 1;
  visibility: visible;
}

.adm-modal {
  background: #2d2d2d;
  border-radius: 10px;
  padding: 24px;
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  z-index: 10000;
}

.adm-modal h3 {
  margin: 0 0 20px 0;
  color: #ffffff;
  font-size: 1.2rem;
  font-weight: 700;
}

.adm-modal-close {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  color: rgba(255, 255, 255, 0.7);
  font-size: 1.2rem;
  cursor: pointer;
  padding: 4px;
  border-radius: 4px;
  transition: 0.3s ease;
}

.adm-modal-close:hover {
  color: #ffffff;
  background: rgba(255, 255, 255, 0.1);
}

.adm-form-group {
  margin-bottom: 16px;
}

.adm-form-group label {
  display: block;
  margin-bottom: 6px;
  color: #ffffff;
  font-size: 0.9rem;
  font-weight: 700;
}

.adm-form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

/* Calendar Styles - Enhanced for Better Readability */
.cal-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 2px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(255, 215, 0, 0.2);
}

.cal-day-header {
  background: linear-gradient(135deg, #FFD700, #FFB000);
  padding: 10px 6px;
  text-align: center;
  font-size: 0.75rem;
  font-weight: 900;
  color: #1a1a1a;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-bottom: 2px solid rgba(26, 26, 26, 0.1);
}

.cal-day {
  background: rgba(0, 0, 0, 0.4);
  min-height: 70px;
  padding: 8px;
  position: relative;
  border: 1px solid rgba(255, 255, 255, 0.07);
  transition: all 0.3s ease;
}

.cal-day:hover {
  background: rgba(0, 0, 0, 0.6);
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(255, 215, 0, 0.2);
}

.cal-day.today {
  background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 176, 0, 0.1));
  border: 2px solid #FFD700;
  box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
}

.cal-day.other-month {
  background: rgba(0, 0, 0, 0.2);
  opacity: 0.4;
}

.cal-day-num {
  font-size: 0.85rem;
  font-weight: 900;
  color: #ffffff;
  margin-bottom: 4px;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.cal-day.today .cal-day-num {
  color: #FFD700;
  font-size: 0.95rem;
  text-shadow: 0 2px 8px rgba(255, 215, 0, 0.5);
}

.cal-event {
  background: rgba(255, 255, 255, 0.15);
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 3px;
  cursor: pointer;
  border-left: 4px solid;
  transition: all 0.3s ease;
  color: #ffffff;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
  line-height: 1.2;
}

.cal-event:hover {
  transform: translateX(2px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  background: rgba(255, 255, 255, 0.25);
}

.cal-event.status-pending {
  border-left-color: #fbbf24;
  background: linear-gradient(135deg, rgba(251, 191, 36, 0.3), rgba(245, 158, 11, 0.2));
}

.cal-event.status-confirmed,
.cal-event.status-processing,
.cal-event.status-out_for_delivery {
  border-left-color: #3b82f6;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.2));
}

.cal-event.status-completed {
  border-left-color: #22c55e;
  background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(22, 163, 74, 0.2));
}

.cal-event.status-cancelled {
  border-left-color: #ef4444;
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(220, 38, 38, 0.2));
  opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 991px) {
  .adm-grid-2 {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .adm-wrap {
    padding: 16px;
  }
  
  .adm-header {
    flex-direction: column;
    gap: 16px;
    align-items: flex-start;
  }
  
  .adm-header-actions {
    flex-wrap: wrap;
    gap: 8px;
  }
  
  .adm-stats {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .quick-actions {
    flex-wrap: wrap;
    overflow-x: visible;
  }
  
  .qa-btn {
    min-width: auto;
    flex: 1 1 calc(50% - 6px);
  }
  
  .adm-table {
    font-size: 0.8rem;
  }
  
  .adm-table th,
  .adm-table td {
    padding: 8px 12px;
  }
  
  .adm-form-row {
    grid-template-columns: 1fr;
  }
  
  .adm-modal {
    width: 95%;
    padding: 20px;
  }
  
  .cal-grid {
    font-size: 0.85rem;
    gap: 1px;
  }
  
  .cal-day-header {
    padding: 8px 4px;
    font-size: 0.7rem;
  }
  
  .cal-day {
    min-height: 60px;
    padding: 6px;
  }
  
  .cal-day-num {
    font-size: 0.8rem;
    margin-bottom: 4px;
  }
  
  .cal-event {
    font-size: 0.65rem;
    padding: 2px 4px;
    margin-bottom: 2px;
    line-height: 1.1;
  }
}

@media (max-width: 575px) {
  .adm-wrap {
    padding: 12px;
  }

  .adm-title {
    font-size: 1.3rem;
  }

  .adm-stats {
    grid-template-columns: 1fr;
  }

  .quick-actions {
    flex-direction: column;
  }

  .qa-btn {
    flex: 1 1 100%;
    width: 100%;
  }

  .adm-card-head {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
}

@media (max-width: 480px) {
  .stat-card {
    padding: 16px;
  }
  
  .stat-icon {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
  }
  
  .stat-num {
    font-size: 1.4rem;
  }
}
</style>


