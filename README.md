# Livincart — Interior Design & Architecture Project Management System (ERP / CRM)

A full-stack, enterprise-grade Project Management and ERP/CRM system engineered specifically for architecture, interior design, and turnkey execution firms. **Livincart** manages the entire lifecycle of interior and architectural projects—from prospective lead capture and BOQ-driven quotations to legal agreements, multi-stage project execution, material tracking, and corporate financial reconciliation.

---

## 📑 Table of Contents

- [Key Highlights & Architecture](#-key-highlights--architecture)
- [System Modules](#-system-modules)
  - [1. Lead Pipeline & CRM](#1-lead-pipeline--crm)
  - [2. Quotation Engine & BOQ Builder](#2-quotation-engine--boq-builder)
  - [3. Client Agreements & Contracts](#3-client-agreements--contracts)
  - [4. Project Timelines & Stage Gates](#4-project-timelines--stage-gates)
  - [5. Financial Management & Accounts](#5-financial-management--accounts)
  - [6. Vendor & Inventory Procurement](#6-vendor--inventory-procurement)
  - [7. Role-Based Dashboards](#7-role-based-dashboards)
  - [8. High-Fidelity PDF Generation Engine](#8-high-fidelity-pdf-generation-engine)
- [Technology Stack](#-technology-stack)
- [Project Directory Structure](#-project-directory-structure)
- [Prerequisites](#-prerequisites)
- [Installation & Quick Start](#-installation--quick-start)
  - [Step 1: Database Setup](#step-1-database-setup)
  - [Step 2: Backend API Configuration](#step-2-backend-api-configuration)
  - [Step 3: Frontend Application Setup](#step-3-frontend-application-setup)
  - [Step 4: PDF Generation Microservice (Puppeteer)](#step-4-pdf-generation-microservice-puppeteer)
- [Service & Port Reference](#-service--port-reference)
- [Security & Access Control](#-security--access-control)
- [Troubleshooting & FAQs](#-troubleshooting--faqs)

---

## 🌟 Key Highlights & Architecture

- **Three-Tier Architecture**:
  - **Frontend UI**: Built with React 19, TypeScript, and Vite for fast rendering and fluid interactions.
  - **Backend REST API**: Lightweight, performant PHP 8.x PDO micro-controllers with rewrite routing.
  - **PDF Microservice**: Dedicated Node.js + Puppeteer service for pixel-perfect PDF rendering of quotations and client agreements.
- **Strict QC Governance**: Built-in Quality Check (QC) gates ensuring project budgets and contracts lock until formal administrative review.
- **Multi-Tenant / Role Partitioning**: Fine-grained access control tailored for Super Admins, Project Heads, Designers, Site Engineers, and Accountants.

---

## 📦 System Modules

### 1. Lead Pipeline & CRM
- Capture and track prospective inquiries across channels (**D1 Leads**, **MMT Leads**, **Site Inquiries**).
- Real-time lead status workflow (New &rarr; Site Visit &rarr; Design Consultation &rarr; Converted to Active Project).
- Comprehensive history log of client discussions, follow-ups, and requirements.

### 2. Quotation Engine & BOQ Builder
- **Dynamic BOQ Generation**: Hierarchical breakdown of Rooms, Modules, Items, Dimensions (Length &times; Breadth &times; Height), Materials, and Rates.
- **Version Control**: Manage multiple quotation drafts and revisions (`v1`, `v2`, `v3`) with full audit histories.
- **Initial vs. Final Budget Lock**: Initial quotation sets the project budget milestone; final quotation remains safely locked until QC approval.
- **Promo Codes & Tax Calculations**: Configurable discount rules and automated GST breakdown (CGST/SGST/IGST).

### 3. Client Agreements & Contracts
- **Automated Legal Contract Generation**: Handover contracts, Interior turnkey agreements, and Furniture consultation packages.
- **Live Snapshot Synchronization**: Pulls approved BOQ modules, milestones, and payment schedule directly into legal documents.
- **Digital Signatures & Terms**: Embed customer specifications, delivery schedules, and customized terms & conditions.

### 4. Project Timelines & Stage Gates
- **5-Stage Execution Framework**:
  1. **Concept & Detailed Design (DD)** (10% milestone)
  2. **Masking & Approvals** (20% cumulative)
  3. **Production / Ready to Produce (R2P)** (60% cumulative)
  4. **Dispatch & Site Execution** (95% cumulative)
  5. **Final Snagging & Handover** (100% completion)
- **Interactive Stage Trackers**: Real-time status tags (*Planned*, *In Progress*, *Pending Approval*, *Completed*).
- **Minutes of Meeting (MoM)**: Site notes, action items, attendee logs, and direct PDF downloads.

### 5. Financial Management & Accounts
- **Cash Flow Tracking**: Real-time reconciliation of **Client Advances (Inflow)** vs. **Site & Vendor Expenses (Outflow)**.
- **Milestone Billing**: Automatically sync payment status with project completion stages.
- **Company Overhead & Expenses**: Category-wise corporate expenses, vendor payments, and operational ledger.
- **Staff Reimbursements**: Employee expense claims, receipt attachments, and approval workflows.
- **Financial Analytics**: Comprehensive Monthly Income reports and revenue projections via interactive Recharts.

### 6. Vendor & Inventory Procurement
- **Global Vendor Directory**: Centralized directory of material suppliers, carpenters, and civil contractors.
- **Vendor Quotas & Rate Contracts**: Issue, track, and compare vendor purchase orders against project BOQs.
- **Site Material Requisitions**: Site engineers raise requests; project managers approve and monitor dispatch.

### 7. Role-Based Dashboards
- **Super Admin**: Complete overview of company finances, cross-project health, and team allocation.
- **Project Head / PM**: Focused tracking of assigned projects, timeline bottlenecks, and QC submissions.
- **Design Team**: 2D/3D deliverables, drawing signoffs, and specification sheets.
- **Site Engineer**: Attendance, daily site logs, material intake, and snag lists.
- **Accountant**: Invoice generation, client payment receipts, and reimbursement reconciliation.

### 8. High-Fidelity PDF Generation Engine
- Pixel-perfect, printable output for **Quotations**, **Client Agreements**, **Minutes of Meeting (MoM)**, and **Vendor Quotas**.
- Hybrid engine supporting both client-side rendering and headless Chrome (Puppeteer) via the local Node.js PDF service.

---

## 🛠️ Technology Stack

| Layer | Technology | Details |
|---|---|---|
| **Frontend** | React 19 + TypeScript | High-performance component architecture |
| **Build Tool** | Vite 8 | Fast HMR and optimized asset bundling |
| **Styling & UI** | Vanilla CSS + MUI Components | Clean, bespoke Livincart theme (`#253b50` Navy) |
| **Icons & Charts** | Lucide React & Recharts | Modern visual indicators and analytics |
| **Backend API** | PHP 8.1+ (PDO) | RESTful controllers, JSON responses |
| **Database** | MySQL 8.x / MariaDB | Relational schema with transactional integrity |
| **PDF Service** | Node.js + Express + Puppeteer | Headless Chrome engine on port 3001 |
| **Web Server** | Apache (XAMPP) | URL rewriting through `.htaccess` |

---

## 📂 Project Directory Structure

```text
livrcart/
├── demoark/
│   ├── api/                              # Backend PHP REST API
│   │   ├── config/
│   │   │   └── database.php              # Database connections & environment URLs
│   │   ├── controllers/                  # 30+ Controller files (Projects, Quotes, Leads, etc.)
│   │   ├── helpers/                      # PDF and utility builders (SimplePdfBuilder.php, etc.)
│   │   ├── uploads/                      # Uploaded site images, documents, and generated caches
│   │   ├── .htaccess                     # URL rewrite routing to index.php
│   │   └── index.php                     # Central API front controller & route dispatcher
│   │
│   ├── frontend/                         # React 19 + TypeScript + Vite Application
│   │   ├── src/
│   │   │   ├── components/               # Layout, QuoteTab, DocumentTab, Modals
│   │   │   ├── hooks/                    # useAuth and custom application hooks
│   │   │   ├── pages/                    # 50+ Module views (Dashboard, Projects, Quotes, etc.)
│   │   │   ├── config.ts                 # API base endpoint configuration
│   │   │   ├── App.tsx                   # React router and route security
│   │   │   ├── main.tsx                  # Root mount entrypoint
│   │   │   └── index.css                 # Master typography & design system
│   │   ├── package.json                  # Frontend dependencies
│   │   └── vite.config.ts                # Vite build and proxy settings
│   │
│   ├── pdf-generator/                    # Dedicated Puppeteer PDF service
│   │   ├── generate-pdf.js               # Express server taking HTML/URLs and returning PDFs
│   │   └── package.json                  # Node.js dependencies (puppeteer, express, pdf-lib)
│   │
│   ├── database/                         # Database seed scripts & migrations
│   └── README.md                         # Inner demoark documentation
│
└── README.md                             # Root system documentation (this file)
```

---

## ⚙️ Prerequisites

Before running the application locally, ensure you have the following installed:
1. **XAMPP** (with **Apache** and **MySQL**, PHP **8.1+**)
2. **Node.js** (v18.x or v20.x LTS) & **npm** (v9+)
3. Modern Web Browser (Google Chrome, Edge, or Firefox)

---

## 🚀 Installation & Quick Start

### Step 1: Database Setup
1. Launch **XAMPP Control Panel** and start both **Apache** and **MySQL**.
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin/`.
3. Create a new database named `updted_liveicart` (collation: `utf8mb4_unicode_ci`).
4. Import the schema file located in:
   ```text
   demoark/ark_pm_system (3).sql
   ```
   *(or run any pending SQL migration scripts located in `demoark/`)*.

---

### Step 2: Backend API Configuration
1. Verify the database credentials in [`demoark/api/config/database.php`](file:///c:/xampp/htdocs/livrcart/demoark/api/config/database.php):
   ```php
   define('IS_PRODUCTION', false);

   // Local Development Settings:
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'updted_liveicart');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('API_BASE_URL', 'http://localhost/livrcart/demoark/api');
   define('FRONTEND_BASE_URL', 'http://localhost:5173');
   define('PDF_GENERATOR_URL', 'http://127.0.0.1:3001');
   ```
2. Verify Apache URL rewrite module (`mod_rewrite`) is enabled in Apache's `httpd.conf`.
3. Test API connectivity by navigating to:
   ```text
   http://localhost/livrcart/demoark/api/
   ```

---

### Step 3: Frontend Application Setup
1. Open a terminal in the frontend directory:
   ```bash
   cd c:\xampp\htdocs\livrcart\demoark\frontend
   ```
2. Install npm dependencies:
   ```bash
   npm install
   ```
3. Verify [`frontend/src/config.ts`](file:///c:/xampp/htdocs/livrcart/demoark/frontend/src/config.ts):
   ```typescript
   export const API_BASE_URL = 'http://localhost/livrcart/demoark/api';
   ```
4. Start the Vite development server:
   ```bash
   npm run dev
   ```
5. The application will be accessible at:
   ```text
   http://localhost:5173
   ```

---

### Step 4: PDF Generation Microservice (Puppeteer)
For pixel-perfect server-side PDF exports of quotes and agreements:
1. Open a terminal in the pdf-generator directory:
   ```bash
   cd c:\xampp\htdocs\livrcart\demoark\pdf-generator
   ```
2. Install dependencies:
   ```bash
   npm install
   ```
3. Start the service:
   ```bash
   npm start
   ```
4. The service listens on `http://127.0.0.1:3001`.

---

## 🌐 Service & Port Reference

| Service | Environment URL | Description |
|---|---|---|
| **Frontend Web App** | `http://localhost:5173` | React/Vite development server |
| **Backend REST API** | `http://localhost/livrcart/demoark/api` | Apache PHP API endpoint |
| **PDF Microservice** | `http://127.0.0.1:3001` | Puppeteer PDF generation server |
| **Database (MySQL)** | `localhost:3306` | Database server (`updted_liveicart`) |

---

## 🔒 Security & Access Control

- **Token-Based Authentication**: Session state and authorization headers passed on protected API routes.
- **Cryptographic Print Tokens**: Puppeteer printing links use HMAC-SHA256 tokens (`PRINT_TOKEN_SECRET`) with short lifespans (10 minutes) to prevent unauthorized document scraping.
- **Role Hierarchy**:
  - `super_admin`: Full system access, company expense auditing, and user management.
  - `project_head` / `manager`: Project stage approvals, assignees, and timeline monitoring.
  - `accountant`: Financial ledger, payment logs, and vendor expense approvals.
  - `site_engineer`: Requisitions, timeline subtasks, and snag progress.

---

## 🛠️ Troubleshooting & FAQs

### 1. API calls return `404 Not Found`
- Ensure Apache has `mod_rewrite` enabled.
- Verify `demoark/api/.htaccess` exists and has `RewriteEngine On`.
- Check that your folder path in `database.php` matches your local Apache document root (`http://localhost/livrcart/demoark/api`).

### 2. CORS Errors in the Browser Console
- The PHP API handles preflight `OPTIONS` requests and sends CORS headers in `api/index.php`.
- Ensure your `FRONTEND_BASE_URL` in `database.php` matches the origin of your frontend (`http://localhost:5173`).

### 3. Puppeteer PDF Generator fails to launch Chrome
- If running on Windows, verify that Chrome/Chromium downloaded properly during `npm install`.
- Ensure flags `--no-sandbox` and `--disable-setuid-sandbox` are configured in `generate-pdf.js`.

### 4. Database Connection Refused
- Ensure MySQL is running in XAMPP.
- Confirm the database name `updted_liveicart` exists in phpMyAdmin and that username/password match `demoark/api/config/database.php`.

---

&copy; **Livincart Architects & Interior Designers**. All rights reserved.
