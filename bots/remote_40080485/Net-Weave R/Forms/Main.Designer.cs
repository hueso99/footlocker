namespace Net_Weave_R.Forms
{
    partial class Main
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Main));
            this.menuClients = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.commandsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.downloadExecuteToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem4 = new System.Windows.Forms.ToolStripSeparator();
            this.uninstallToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.pluginsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sendToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.viewToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem5 = new System.Windows.Forms.ToolStripSeparator();
            this.flags = new System.Windows.Forms.ImageList(this.components);
            this.carbonTheme1 = new CarbonTheme();
            this.panelMain = new System.Windows.Forms.Panel();
            this.btnSettings = new CarbonButton();
            this.btnPlugins = new CarbonButton();
            this.btnFloodPanel = new CarbonButton();
            this.btnBuilder = new CarbonButton();
            this.btnLog = new CarbonButton();
            this.tabPanelMain = new System.Windows.Forms.Panel();
            this.lstClients = new NetLib.Forms.xListview();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader2 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader3 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader4 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader5 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader6 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader7 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.menuToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.startToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripSeparator();
            this.builderF2ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.floodPanelF3ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.pluginPanelF4ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem2 = new System.Windows.Forms.ToolStripSeparator();
            this.settingsF5ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.chatF6ToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem3 = new System.Windows.Forms.ToolStripSeparator();
            this.bugReportToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.portMapperToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.clientsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.viewToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.scrollToLatestToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.countryByGeoIPToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.selectToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.allToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.iPAddressesToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.xHideIPs = new System.Windows.Forms.ToolStripMenuItem();
            this.copyToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.selectedToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.allToolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.aboutToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.ss = new System.Windows.Forms.StatusStrip();
            this.lblOnline = new System.Windows.Forms.ToolStripStatusLabel();
            this.toolStripStatusLabel2 = new System.Windows.Forms.ToolStripStatusLabel();
            this.lblPeak = new System.Windows.Forms.ToolStripStatusLabel();
            this.toolStripStatusLabel4 = new System.Windows.Forms.ToolStripStatusLabel();
            this.lblTotal = new System.Windows.Forms.ToolStripStatusLabel();
            this.toolStripStatusLabel1 = new System.Windows.Forms.ToolStripStatusLabel();
            this.lblSelected = new System.Windows.Forms.ToolStripStatusLabel();
            this.toolStripStatusLabel6 = new System.Windows.Forms.ToolStripStatusLabel();
            this.lblTotalSpeed = new System.Windows.Forms.ToolStripStatusLabel();
            this.toolStripStatusLabel5 = new System.Windows.Forms.ToolStripStatusLabel();
            this.lblFloodTimer = new System.Windows.Forms.ToolStripStatusLabel();
            this.ni = new System.Windows.Forms.NotifyIcon(this.components);
            this.menuClients.SuspendLayout();
            this.carbonTheme1.SuspendLayout();
            this.panelMain.SuspendLayout();
            this.tabPanelMain.SuspendLayout();
            this.menuStrip1.SuspendLayout();
            this.ss.SuspendLayout();
            this.SuspendLayout();
            // 
            // menuClients
            // 
            this.menuClients.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.commandsToolStripMenuItem,
            this.pluginsToolStripMenuItem});
            this.menuClients.Name = "menuClients";
            this.menuClients.Size = new System.Drawing.Size(137, 48);
            // 
            // commandsToolStripMenuItem
            // 
            this.commandsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.downloadExecuteToolStripMenuItem,
            this.toolStripMenuItem4,
            this.uninstallToolStripMenuItem});
            this.commandsToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("commandsToolStripMenuItem.Image")));
            this.commandsToolStripMenuItem.Name = "commandsToolStripMenuItem";
            this.commandsToolStripMenuItem.Size = new System.Drawing.Size(136, 22);
            this.commandsToolStripMenuItem.Text = "Commands";
            // 
            // downloadExecuteToolStripMenuItem
            // 
            this.downloadExecuteToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("downloadExecuteToolStripMenuItem.Image")));
            this.downloadExecuteToolStripMenuItem.Name = "downloadExecuteToolStripMenuItem";
            this.downloadExecuteToolStripMenuItem.Size = new System.Drawing.Size(173, 22);
            this.downloadExecuteToolStripMenuItem.Text = "Download\\Execute";
            this.downloadExecuteToolStripMenuItem.Click += new System.EventHandler(this.downloadExecuteToolStripMenuItem_Click);
            // 
            // toolStripMenuItem4
            // 
            this.toolStripMenuItem4.Name = "toolStripMenuItem4";
            this.toolStripMenuItem4.Size = new System.Drawing.Size(170, 6);
            // 
            // uninstallToolStripMenuItem
            // 
            this.uninstallToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("uninstallToolStripMenuItem.Image")));
            this.uninstallToolStripMenuItem.Name = "uninstallToolStripMenuItem";
            this.uninstallToolStripMenuItem.Size = new System.Drawing.Size(173, 22);
            this.uninstallToolStripMenuItem.Text = "Uninstall";
            this.uninstallToolStripMenuItem.Click += new System.EventHandler(this.uninstallToolStripMenuItem_Click);
            // 
            // pluginsToolStripMenuItem
            // 
            this.pluginsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.sendToolStripMenuItem,
            this.viewToolStripMenuItem1,
            this.toolStripMenuItem5});
            this.pluginsToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("pluginsToolStripMenuItem.Image")));
            this.pluginsToolStripMenuItem.Name = "pluginsToolStripMenuItem";
            this.pluginsToolStripMenuItem.Size = new System.Drawing.Size(136, 22);
            this.pluginsToolStripMenuItem.Text = "Plugins";
            // 
            // sendToolStripMenuItem
            // 
            this.sendToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("sendToolStripMenuItem.Image")));
            this.sendToolStripMenuItem.Name = "sendToolStripMenuItem";
            this.sendToolStripMenuItem.Size = new System.Drawing.Size(100, 22);
            this.sendToolStripMenuItem.Text = "Send";
            this.sendToolStripMenuItem.Click += new System.EventHandler(this.sendToolStripMenuItem_Click);
            // 
            // viewToolStripMenuItem1
            // 
            this.viewToolStripMenuItem1.Image = ((System.Drawing.Image)(resources.GetObject("viewToolStripMenuItem1.Image")));
            this.viewToolStripMenuItem1.Name = "viewToolStripMenuItem1";
            this.viewToolStripMenuItem1.Size = new System.Drawing.Size(100, 22);
            this.viewToolStripMenuItem1.Text = "View";
            this.viewToolStripMenuItem1.Click += new System.EventHandler(this.viewToolStripMenuItem1_Click);
            // 
            // toolStripMenuItem5
            // 
            this.toolStripMenuItem5.Name = "toolStripMenuItem5";
            this.toolStripMenuItem5.Size = new System.Drawing.Size(97, 6);
            // 
            // flags
            // 
            this.flags.ImageStream = ((System.Windows.Forms.ImageListStreamer)(resources.GetObject("flags.ImageStream")));
            this.flags.TransparentColor = System.Drawing.Color.Transparent;
            this.flags.Images.SetKeyName(0, "Afghanistan.png");
            this.flags.Images.SetKeyName(1, "African Union.png");
            this.flags.Images.SetKeyName(2, "Albania.png");
            this.flags.Images.SetKeyName(3, "Algeria.png");
            this.flags.Images.SetKeyName(4, "American Samoa.png");
            this.flags.Images.SetKeyName(5, "Andorra.png");
            this.flags.Images.SetKeyName(6, "Angola.png");
            this.flags.Images.SetKeyName(7, "Anguilla.png");
            this.flags.Images.SetKeyName(8, "Antarctica.png");
            this.flags.Images.SetKeyName(9, "Antigua & Barbuda.png");
            this.flags.Images.SetKeyName(10, "Arab League.png");
            this.flags.Images.SetKeyName(11, "Argentina.png");
            this.flags.Images.SetKeyName(12, "Armenia.png");
            this.flags.Images.SetKeyName(13, "Aruba.png");
            this.flags.Images.SetKeyName(14, "ASEAN.png");
            this.flags.Images.SetKeyName(15, "Australia.png");
            this.flags.Images.SetKeyName(16, "Austria.png");
            this.flags.Images.SetKeyName(17, "Azerbaijan.png");
            this.flags.Images.SetKeyName(18, "Bahamas.png");
            this.flags.Images.SetKeyName(19, "Bahrain.png");
            this.flags.Images.SetKeyName(20, "Bangladesh.png");
            this.flags.Images.SetKeyName(21, "Barbados.png");
            this.flags.Images.SetKeyName(22, "Belarus.png");
            this.flags.Images.SetKeyName(23, "Belgium.png");
            this.flags.Images.SetKeyName(24, "Belize.png");
            this.flags.Images.SetKeyName(25, "Benin.png");
            this.flags.Images.SetKeyName(26, "Bermuda.png");
            this.flags.Images.SetKeyName(27, "Bhutan.png");
            this.flags.Images.SetKeyName(28, "Bolivia.png");
            this.flags.Images.SetKeyName(29, "Bosnia & Herzegovina.png");
            this.flags.Images.SetKeyName(30, "Botswana.png");
            this.flags.Images.SetKeyName(31, "Brazil.png");
            this.flags.Images.SetKeyName(32, "Brunei.png");
            this.flags.Images.SetKeyName(33, "Bulgaria.png");
            this.flags.Images.SetKeyName(34, "Burkina Faso.png");
            this.flags.Images.SetKeyName(35, "Burundi.png");
            this.flags.Images.SetKeyName(36, "Cambodja.png");
            this.flags.Images.SetKeyName(37, "Cameroon.png");
            this.flags.Images.SetKeyName(38, "Canada.png");
            this.flags.Images.SetKeyName(39, "Cape Verde.png");
            this.flags.Images.SetKeyName(40, "CARICOM.png");
            this.flags.Images.SetKeyName(41, "Cayman Islands.png");
            this.flags.Images.SetKeyName(42, "Central African Republic.png");
            this.flags.Images.SetKeyName(43, "Chad.png");
            this.flags.Images.SetKeyName(44, "Chile.png");
            this.flags.Images.SetKeyName(45, "China.png");
            this.flags.Images.SetKeyName(46, "CIS.png");
            this.flags.Images.SetKeyName(47, "Colombia.png");
            this.flags.Images.SetKeyName(48, "Commonwealth.png");
            this.flags.Images.SetKeyName(49, "Comoros.png");
            this.flags.Images.SetKeyName(50, "Congo-Brazzaville.png");
            this.flags.Images.SetKeyName(51, "Congo-Kinshasa(Zaire).png");
            this.flags.Images.SetKeyName(52, "Cook Islands.png");
            this.flags.Images.SetKeyName(53, "Costa Rica.png");
            this.flags.Images.SetKeyName(54, "Cote d\'Ivoire.png");
            this.flags.Images.SetKeyName(55, "Croatia.png");
            this.flags.Images.SetKeyName(56, "Cuba.png");
            this.flags.Images.SetKeyName(57, "Cyprus.png");
            this.flags.Images.SetKeyName(58, "Czech Republic.png");
            this.flags.Images.SetKeyName(59, "Denmark.png");
            this.flags.Images.SetKeyName(60, "Djibouti.png");
            this.flags.Images.SetKeyName(61, "Dominica.png");
            this.flags.Images.SetKeyName(62, "Dominican Republic.png");
            this.flags.Images.SetKeyName(63, "Ecuador.png");
            this.flags.Images.SetKeyName(64, "Egypt.png");
            this.flags.Images.SetKeyName(65, "El Salvador.png");
            this.flags.Images.SetKeyName(66, "England.png");
            this.flags.Images.SetKeyName(67, "Equatorial Guinea.png");
            this.flags.Images.SetKeyName(68, "Eritrea.png");
            this.flags.Images.SetKeyName(69, "Estonia.png");
            this.flags.Images.SetKeyName(70, "Ethiopia.png");
            this.flags.Images.SetKeyName(71, "European Union.png");
            this.flags.Images.SetKeyName(72, "Faroes.png");
            this.flags.Images.SetKeyName(73, "Fiji.png");
            this.flags.Images.SetKeyName(74, "Finland.png");
            this.flags.Images.SetKeyName(75, "France.png");
            this.flags.Images.SetKeyName(76, "Gabon.png");
            this.flags.Images.SetKeyName(77, "Gambia.png");
            this.flags.Images.SetKeyName(78, "Georgia.png");
            this.flags.Images.SetKeyName(79, "Germany.png");
            this.flags.Images.SetKeyName(80, "Ghana.png");
            this.flags.Images.SetKeyName(81, "Gibraltar.png");
            this.flags.Images.SetKeyName(82, "Greece.png");
            this.flags.Images.SetKeyName(83, "Greenland.png");
            this.flags.Images.SetKeyName(84, "Grenada.png");
            this.flags.Images.SetKeyName(85, "Guadeloupe.png");
            this.flags.Images.SetKeyName(86, "Guademala.png");
            this.flags.Images.SetKeyName(87, "Guam.png");
            this.flags.Images.SetKeyName(88, "Guernsey.png");
            this.flags.Images.SetKeyName(89, "Guinea.png");
            this.flags.Images.SetKeyName(90, "Guinea-Bissau.png");
            this.flags.Images.SetKeyName(91, "Guyana.png");
            this.flags.Images.SetKeyName(92, "Haiti.png");
            this.flags.Images.SetKeyName(93, "Honduras.png");
            this.flags.Images.SetKeyName(94, "Hong Kong.png");
            this.flags.Images.SetKeyName(95, "Hungary.png");
            this.flags.Images.SetKeyName(96, "Iceland.png");
            this.flags.Images.SetKeyName(97, "India.png");
            this.flags.Images.SetKeyName(98, "Indonesia.png");
            this.flags.Images.SetKeyName(99, "Iran.png");
            this.flags.Images.SetKeyName(100, "Iraq.png");
            this.flags.Images.SetKeyName(101, "Ireland.png");
            this.flags.Images.SetKeyName(102, "Islamic Conference.png");
            this.flags.Images.SetKeyName(103, "Isle of Man.png");
            this.flags.Images.SetKeyName(104, "Israel.png");
            this.flags.Images.SetKeyName(105, "Italy.png");
            this.flags.Images.SetKeyName(106, "Jamaica.png");
            this.flags.Images.SetKeyName(107, "Japan.png");
            this.flags.Images.SetKeyName(108, "Jersey.png");
            this.flags.Images.SetKeyName(109, "Jordan.png");
            this.flags.Images.SetKeyName(110, "Kazakhstan.png");
            this.flags.Images.SetKeyName(111, "Kenya.png");
            this.flags.Images.SetKeyName(112, "Kiribati.png");
            this.flags.Images.SetKeyName(113, "Kosovo.png");
            this.flags.Images.SetKeyName(114, "Kuwait.png");
            this.flags.Images.SetKeyName(115, "Kyrgyzstan.png");
            this.flags.Images.SetKeyName(116, "Laos.png");
            this.flags.Images.SetKeyName(117, "Latvia.png");
            this.flags.Images.SetKeyName(118, "Lebanon.png");
            this.flags.Images.SetKeyName(119, "Lesotho.png");
            this.flags.Images.SetKeyName(120, "Liberia.png");
            this.flags.Images.SetKeyName(121, "Libya.png");
            this.flags.Images.SetKeyName(122, "Liechtenstein.png");
            this.flags.Images.SetKeyName(123, "Lithuania.png");
            this.flags.Images.SetKeyName(124, "Luxembourg.png");
            this.flags.Images.SetKeyName(125, "Macao.png");
            this.flags.Images.SetKeyName(126, "Macedonia.png");
            this.flags.Images.SetKeyName(127, "Madagascar.png");
            this.flags.Images.SetKeyName(128, "Malawi.png");
            this.flags.Images.SetKeyName(129, "Malaysia.png");
            this.flags.Images.SetKeyName(130, "Maldives.png");
            this.flags.Images.SetKeyName(131, "Mali.png");
            this.flags.Images.SetKeyName(132, "Malta.png");
            this.flags.Images.SetKeyName(133, "Marshall Islands.png");
            this.flags.Images.SetKeyName(134, "Martinique.png");
            this.flags.Images.SetKeyName(135, "Mauritania.png");
            this.flags.Images.SetKeyName(136, "Mauritius.png");
            this.flags.Images.SetKeyName(137, "Mexico.png");
            this.flags.Images.SetKeyName(138, "Micronesia.png");
            this.flags.Images.SetKeyName(139, "Moldova.png");
            this.flags.Images.SetKeyName(140, "Monaco.png");
            this.flags.Images.SetKeyName(141, "Mongolia.png");
            this.flags.Images.SetKeyName(142, "Montenegro.png");
            this.flags.Images.SetKeyName(143, "Montserrat.png");
            this.flags.Images.SetKeyName(144, "Morocco.png");
            this.flags.Images.SetKeyName(145, "Mozambique.png");
            this.flags.Images.SetKeyName(146, "Myanmar(Burma).png");
            this.flags.Images.SetKeyName(147, "Namibia.png");
            this.flags.Images.SetKeyName(148, "NATO.png");
            this.flags.Images.SetKeyName(149, "Nauru.png");
            this.flags.Images.SetKeyName(150, "Nepal.png");
            this.flags.Images.SetKeyName(151, "Netherlands Antilles.png");
            this.flags.Images.SetKeyName(152, "Netherlands.png");
            this.flags.Images.SetKeyName(153, "New Caledonia.png");
            this.flags.Images.SetKeyName(154, "New Zealand.png");
            this.flags.Images.SetKeyName(155, "Nicaragua.png");
            this.flags.Images.SetKeyName(156, "Niger.png");
            this.flags.Images.SetKeyName(157, "Nigeria.png");
            this.flags.Images.SetKeyName(158, "North Korea.png");
            this.flags.Images.SetKeyName(159, "Northern Cyprus.png");
            this.flags.Images.SetKeyName(160, "Northern Ireland.png");
            this.flags.Images.SetKeyName(161, "Norway.png");
            this.flags.Images.SetKeyName(162, "Olimpic Movement.png");
            this.flags.Images.SetKeyName(163, "Oman.png");
            this.flags.Images.SetKeyName(164, "OPEC.png");
            this.flags.Images.SetKeyName(165, "Pakistan.png");
            this.flags.Images.SetKeyName(166, "Palau.png");
            this.flags.Images.SetKeyName(167, "Palestine.png");
            this.flags.Images.SetKeyName(168, "Panama.png");
            this.flags.Images.SetKeyName(169, "Papua New Guinea.png");
            this.flags.Images.SetKeyName(170, "Paraguay.png");
            this.flags.Images.SetKeyName(171, "Peru.png");
            this.flags.Images.SetKeyName(172, "Philippines.png");
            this.flags.Images.SetKeyName(173, "Poland.png");
            this.flags.Images.SetKeyName(174, "Portugal.png");
            this.flags.Images.SetKeyName(175, "Puerto Rico.png");
            this.flags.Images.SetKeyName(176, "Qatar.png");
            this.flags.Images.SetKeyName(177, "Red Cross.png");
            this.flags.Images.SetKeyName(178, "Reunion.png");
            this.flags.Images.SetKeyName(179, "Romania.png");
            this.flags.Images.SetKeyName(180, "Russian Federation.png");
            this.flags.Images.SetKeyName(181, "Rwanda.png");
            this.flags.Images.SetKeyName(182, "Saint Lucia.png");
            this.flags.Images.SetKeyName(183, "Samoa.png");
            this.flags.Images.SetKeyName(184, "San Marino.png");
            this.flags.Images.SetKeyName(185, "Sao Tome & Principe.png");
            this.flags.Images.SetKeyName(186, "Saudi Arabia.png");
            this.flags.Images.SetKeyName(187, "Scotland.png");
            this.flags.Images.SetKeyName(188, "Senegal.png");
            this.flags.Images.SetKeyName(189, "Serbia.png");
            this.flags.Images.SetKeyName(190, "Seyshelles.png");
            this.flags.Images.SetKeyName(191, "Sierra Leone.png");
            this.flags.Images.SetKeyName(192, "Singapore.png");
            this.flags.Images.SetKeyName(193, "Slovakia.png");
            this.flags.Images.SetKeyName(194, "Slovenia.png");
            this.flags.Images.SetKeyName(195, "Solomon Islands.png");
            this.flags.Images.SetKeyName(196, "Somalia.png");
            this.flags.Images.SetKeyName(197, "Somaliland.png");
            this.flags.Images.SetKeyName(198, "South Africa.png");
            this.flags.Images.SetKeyName(199, "South Korea.png");
            this.flags.Images.SetKeyName(200, "Spain.png");
            this.flags.Images.SetKeyName(201, "Sri Lanka.png");
            this.flags.Images.SetKeyName(202, "St Kitts & Nevis.png");
            this.flags.Images.SetKeyName(203, "St Vincent & the Grenadines.png");
            this.flags.Images.SetKeyName(204, "Sudan.png");
            this.flags.Images.SetKeyName(205, "Suriname.png");
            this.flags.Images.SetKeyName(206, "Swaziland.png");
            this.flags.Images.SetKeyName(207, "Sweden.png");
            this.flags.Images.SetKeyName(208, "Switzerland.png");
            this.flags.Images.SetKeyName(209, "Syria.png");
            this.flags.Images.SetKeyName(210, "Tahiti(French Polinesia).png");
            this.flags.Images.SetKeyName(211, "Taiwan.png");
            this.flags.Images.SetKeyName(212, "Tajikistan.png");
            this.flags.Images.SetKeyName(213, "Tanzania.png");
            this.flags.Images.SetKeyName(214, "Thailand.png");
            this.flags.Images.SetKeyName(215, "Timor-Leste.png");
            this.flags.Images.SetKeyName(216, "Togo.png");
            this.flags.Images.SetKeyName(217, "Tonga.png");
            this.flags.Images.SetKeyName(218, "Trinidad & Tobago.png");
            this.flags.Images.SetKeyName(219, "Tunisia.png");
            this.flags.Images.SetKeyName(220, "Turkey.png");
            this.flags.Images.SetKeyName(221, "Turkmenistan.png");
            this.flags.Images.SetKeyName(222, "Turks and Caicos Islands.png");
            this.flags.Images.SetKeyName(223, "Tuvalu.png");
            this.flags.Images.SetKeyName(224, "Uganda.png");
            this.flags.Images.SetKeyName(225, "Ukraine.png");
            this.flags.Images.SetKeyName(226, "United Arab Emirates.png");
            this.flags.Images.SetKeyName(227, "United Kingdom(Great Britain).png");
            this.flags.Images.SetKeyName(228, "United Nations.png");
            this.flags.Images.SetKeyName(229, "United States of America.png");
            this.flags.Images.SetKeyName(230, "Uruguay.png");
            this.flags.Images.SetKeyName(231, "Uzbekistan.png");
            this.flags.Images.SetKeyName(232, "Vanutau.png");
            this.flags.Images.SetKeyName(233, "Vatican City.png");
            this.flags.Images.SetKeyName(234, "Venezuela.png");
            this.flags.Images.SetKeyName(235, "Viet Nam.png");
            this.flags.Images.SetKeyName(236, "Virgin Islands British.png");
            this.flags.Images.SetKeyName(237, "Virgin Islands US.png");
            this.flags.Images.SetKeyName(238, "Wales.png");
            this.flags.Images.SetKeyName(239, "Western Sahara.png");
            this.flags.Images.SetKeyName(240, "Yemen.png");
            this.flags.Images.SetKeyName(241, "Zambia.png");
            this.flags.Images.SetKeyName(242, "Zimbabwe.png");
            this.flags.Images.SetKeyName(243, "--.png");
            // 
            // carbonTheme1
            // 
            this.carbonTheme1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonTheme1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonTheme1.ControlBox = true;
            this.carbonTheme1.Controls.Add(this.panelMain);
            this.carbonTheme1.Customization = "wMDA/8DAwP96enr/09PT/0ZGRv+Wlpb/AAAA/////27///8e////AAAAAP9WVlb/";
            this.carbonTheme1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.carbonTheme1.DrawHatch = true;
            this.carbonTheme1.EnableExit = true;
            this.carbonTheme1.EnableMaximize = false;
            this.carbonTheme1.EnableMinimize = true;
            this.carbonTheme1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonTheme1.Image = null;
            this.carbonTheme1.Location = new System.Drawing.Point(0, 0);
            this.carbonTheme1.Movable = true;
            this.carbonTheme1.Name = "carbonTheme1";
            this.carbonTheme1.NoRounding = false;
            this.carbonTheme1.Sizable = false;
            this.carbonTheme1.Size = new System.Drawing.Size(774, 487);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Net-Weave R";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panelMain
            // 
            this.panelMain.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panelMain.Controls.Add(this.btnSettings);
            this.panelMain.Controls.Add(this.btnPlugins);
            this.panelMain.Controls.Add(this.btnFloodPanel);
            this.panelMain.Controls.Add(this.btnBuilder);
            this.panelMain.Controls.Add(this.btnLog);
            this.panelMain.Controls.Add(this.tabPanelMain);
            this.panelMain.Controls.Add(this.menuStrip1);
            this.panelMain.Controls.Add(this.ss);
            this.panelMain.Location = new System.Drawing.Point(12, 27);
            this.panelMain.Name = "panelMain";
            this.panelMain.Size = new System.Drawing.Size(750, 448);
            this.panelMain.TabIndex = 3;
            // 
            // btnSettings
            // 
            this.btnSettings.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.btnSettings.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnSettings.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnSettings.Image = null;
            this.btnSettings.Location = new System.Drawing.Point(468, 0);
            this.btnSettings.Name = "btnSettings";
            this.btnSettings.NoRounding = false;
            this.btnSettings.Size = new System.Drawing.Size(84, 23);
            this.btnSettings.TabIndex = 11;
            this.btnSettings.Text = "Settings";
            this.btnSettings.Transparent = false;
            this.btnSettings.Click += new System.EventHandler(this.btnSettings_Click);
            // 
            // btnPlugins
            // 
            this.btnPlugins.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.btnPlugins.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnPlugins.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnPlugins.Image = null;
            this.btnPlugins.Location = new System.Drawing.Point(378, 0);
            this.btnPlugins.Name = "btnPlugins";
            this.btnPlugins.NoRounding = false;
            this.btnPlugins.Size = new System.Drawing.Size(84, 23);
            this.btnPlugins.TabIndex = 10;
            this.btnPlugins.Text = "Plugins";
            this.btnPlugins.Transparent = false;
            this.btnPlugins.Click += new System.EventHandler(this.btnPlugins_Click);
            // 
            // btnFloodPanel
            // 
            this.btnFloodPanel.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.btnFloodPanel.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnFloodPanel.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnFloodPanel.Image = null;
            this.btnFloodPanel.Location = new System.Drawing.Point(288, 0);
            this.btnFloodPanel.Name = "btnFloodPanel";
            this.btnFloodPanel.NoRounding = false;
            this.btnFloodPanel.Size = new System.Drawing.Size(84, 23);
            this.btnFloodPanel.TabIndex = 8;
            this.btnFloodPanel.Text = "Flood Panel";
            this.btnFloodPanel.Transparent = false;
            this.btnFloodPanel.Click += new System.EventHandler(this.btnFloodPanel_Click);
            // 
            // btnBuilder
            // 
            this.btnBuilder.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.btnBuilder.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnBuilder.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnBuilder.Image = null;
            this.btnBuilder.Location = new System.Drawing.Point(198, 0);
            this.btnBuilder.Name = "btnBuilder";
            this.btnBuilder.NoRounding = false;
            this.btnBuilder.Size = new System.Drawing.Size(84, 23);
            this.btnBuilder.TabIndex = 9;
            this.btnBuilder.Text = "Builder";
            this.btnBuilder.Transparent = false;
            this.btnBuilder.Click += new System.EventHandler(this.btnBuilder_Click);
            // 
            // btnLog
            // 
            this.btnLog.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.btnLog.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnLog.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnLog.Image = null;
            this.btnLog.Location = new System.Drawing.Point(701, 0);
            this.btnLog.Name = "btnLog";
            this.btnLog.NoRounding = false;
            this.btnLog.Size = new System.Drawing.Size(48, 23);
            this.btnLog.TabIndex = 7;
            this.btnLog.Text = "Log >";
            this.btnLog.Transparent = false;
            this.btnLog.Click += new System.EventHandler(this.btnLog_Click);
            // 
            // tabPanelMain
            // 
            this.tabPanelMain.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.tabPanelMain.Controls.Add(this.lstClients);
            this.tabPanelMain.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.tabPanelMain.Location = new System.Drawing.Point(0, 24);
            this.tabPanelMain.Name = "tabPanelMain";
            this.tabPanelMain.Size = new System.Drawing.Size(750, 402);
            this.tabPanelMain.TabIndex = 6;
            // 
            // lstClients
            // 
            this.lstClients.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.lstClients.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader2,
            this.columnHeader3,
            this.columnHeader4,
            this.columnHeader5,
            this.columnHeader6,
            this.columnHeader7});
            this.lstClients.ContextMenuStrip = this.menuClients;
            this.lstClients.Dock = System.Windows.Forms.DockStyle.Fill;
            this.lstClients.FullRowSelect = true;
            this.lstClients.Location = new System.Drawing.Point(0, 0);
            this.lstClients.Name = "lstClients";
            this.lstClients.Size = new System.Drawing.Size(748, 400);
            this.lstClients.SmallImageList = this.flags;
            this.lstClients.TabIndex = 3;
            this.lstClients.UseCompatibleStateImageBehavior = false;
            this.lstClients.View = System.Windows.Forms.View.Details;
            this.lstClients.SelectedIndexChanged += new System.EventHandler(this.lstClients_SelectedIndexChanged);
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "IP Address";
            this.columnHeader1.Width = 118;
            // 
            // columnHeader2
            // 
            this.columnHeader2.Text = "Country";
            this.columnHeader2.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            this.columnHeader2.Width = 125;
            // 
            // columnHeader3
            // 
            this.columnHeader3.Text = "Operating System";
            this.columnHeader3.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            this.columnHeader3.Width = 149;
            // 
            // columnHeader4
            // 
            this.columnHeader4.Text = "Response";
            this.columnHeader4.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            this.columnHeader4.Width = 130;
            // 
            // columnHeader5
            // 
            this.columnHeader5.Text = "Ver";
            this.columnHeader5.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            this.columnHeader5.Width = 52;
            // 
            // columnHeader6
            // 
            this.columnHeader6.Text = "Speed";
            this.columnHeader6.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            this.columnHeader6.Width = 81;
            // 
            // columnHeader7
            // 
            this.columnHeader7.Text = "Port";
            this.columnHeader7.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
            // 
            // menuStrip1
            // 
            this.menuStrip1.BackColor = System.Drawing.Color.Transparent;
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.menuToolStripMenuItem,
            this.clientsToolStripMenuItem,
            this.aboutToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(750, 24);
            this.menuStrip1.TabIndex = 12;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // menuToolStripMenuItem
            // 
            this.menuToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.startToolStripMenuItem,
            this.toolStripMenuItem1,
            this.builderF2ToolStripMenuItem,
            this.floodPanelF3ToolStripMenuItem,
            this.pluginPanelF4ToolStripMenuItem,
            this.toolStripMenuItem2,
            this.settingsF5ToolStripMenuItem,
            this.chatF6ToolStripMenuItem,
            this.toolStripMenuItem3,
            this.bugReportToolStripMenuItem,
            this.portMapperToolStripMenuItem});
            this.menuToolStripMenuItem.Name = "menuToolStripMenuItem";
            this.menuToolStripMenuItem.Size = new System.Drawing.Size(50, 20);
            this.menuToolStripMenuItem.Text = "Menu";
            // 
            // startToolStripMenuItem
            // 
            this.startToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("startToolStripMenuItem.Image")));
            this.startToolStripMenuItem.Name = "startToolStripMenuItem";
            this.startToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.startToolStripMenuItem.Text = "Listen - F1";
            this.startToolStripMenuItem.Click += new System.EventHandler(this.startToolStripMenuItem_Click);
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(160, 6);
            // 
            // builderF2ToolStripMenuItem
            // 
            this.builderF2ToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("builderF2ToolStripMenuItem.Image")));
            this.builderF2ToolStripMenuItem.Name = "builderF2ToolStripMenuItem";
            this.builderF2ToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.builderF2ToolStripMenuItem.Text = "Builder - F2";
            this.builderF2ToolStripMenuItem.Click += new System.EventHandler(this.builderF2ToolStripMenuItem_Click);
            // 
            // floodPanelF3ToolStripMenuItem
            // 
            this.floodPanelF3ToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("floodPanelF3ToolStripMenuItem.Image")));
            this.floodPanelF3ToolStripMenuItem.Name = "floodPanelF3ToolStripMenuItem";
            this.floodPanelF3ToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.floodPanelF3ToolStripMenuItem.Text = "Flood Panel - F3";
            this.floodPanelF3ToolStripMenuItem.Click += new System.EventHandler(this.floodPanelF3ToolStripMenuItem_Click);
            // 
            // pluginPanelF4ToolStripMenuItem
            // 
            this.pluginPanelF4ToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("pluginPanelF4ToolStripMenuItem.Image")));
            this.pluginPanelF4ToolStripMenuItem.Name = "pluginPanelF4ToolStripMenuItem";
            this.pluginPanelF4ToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.pluginPanelF4ToolStripMenuItem.Text = "Plugin Panel - F4";
            // 
            // toolStripMenuItem2
            // 
            this.toolStripMenuItem2.Name = "toolStripMenuItem2";
            this.toolStripMenuItem2.Size = new System.Drawing.Size(160, 6);
            // 
            // settingsF5ToolStripMenuItem
            // 
            this.settingsF5ToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("settingsF5ToolStripMenuItem.Image")));
            this.settingsF5ToolStripMenuItem.Name = "settingsF5ToolStripMenuItem";
            this.settingsF5ToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.settingsF5ToolStripMenuItem.Text = "Settings - F5";
            this.settingsF5ToolStripMenuItem.Click += new System.EventHandler(this.settingsF5ToolStripMenuItem_Click);
            // 
            // chatF6ToolStripMenuItem
            // 
            this.chatF6ToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("chatF6ToolStripMenuItem.Image")));
            this.chatF6ToolStripMenuItem.Name = "chatF6ToolStripMenuItem";
            this.chatF6ToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.chatF6ToolStripMenuItem.Text = "Chat - F6";
            this.chatF6ToolStripMenuItem.Click += new System.EventHandler(this.chatF6ToolStripMenuItem_Click);
            // 
            // toolStripMenuItem3
            // 
            this.toolStripMenuItem3.Name = "toolStripMenuItem3";
            this.toolStripMenuItem3.Size = new System.Drawing.Size(160, 6);
            // 
            // bugReportToolStripMenuItem
            // 
            this.bugReportToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("bugReportToolStripMenuItem.Image")));
            this.bugReportToolStripMenuItem.Name = "bugReportToolStripMenuItem";
            this.bugReportToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.bugReportToolStripMenuItem.Text = "Bug Report";
            this.bugReportToolStripMenuItem.Click += new System.EventHandler(this.bugReportToolStripMenuItem_Click);
            // 
            // portMapperToolStripMenuItem
            // 
            this.portMapperToolStripMenuItem.Image = ((System.Drawing.Image)(resources.GetObject("portMapperToolStripMenuItem.Image")));
            this.portMapperToolStripMenuItem.Name = "portMapperToolStripMenuItem";
            this.portMapperToolStripMenuItem.Size = new System.Drawing.Size(163, 22);
            this.portMapperToolStripMenuItem.Text = "Port Mapper";
            this.portMapperToolStripMenuItem.Click += new System.EventHandler(this.portMapperToolStripMenuItem_Click);
            // 
            // clientsToolStripMenuItem
            // 
            this.clientsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.viewToolStripMenuItem,
            this.selectToolStripMenuItem,
            this.iPAddressesToolStripMenuItem});
            this.clientsToolStripMenuItem.Name = "clientsToolStripMenuItem";
            this.clientsToolStripMenuItem.Size = new System.Drawing.Size(55, 20);
            this.clientsToolStripMenuItem.Text = "Clients";
            // 
            // viewToolStripMenuItem
            // 
            this.viewToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.scrollToLatestToolStripMenuItem,
            this.countryByGeoIPToolStripMenuItem});
            this.viewToolStripMenuItem.Name = "viewToolStripMenuItem";
            this.viewToolStripMenuItem.Size = new System.Drawing.Size(140, 22);
            this.viewToolStripMenuItem.Text = "View";
            // 
            // scrollToLatestToolStripMenuItem
            // 
            this.scrollToLatestToolStripMenuItem.CheckOnClick = true;
            this.scrollToLatestToolStripMenuItem.Name = "scrollToLatestToolStripMenuItem";
            this.scrollToLatestToolStripMenuItem.Size = new System.Drawing.Size(167, 22);
            this.scrollToLatestToolStripMenuItem.Text = "Scroll to Latest";
            // 
            // countryByGeoIPToolStripMenuItem
            // 
            this.countryByGeoIPToolStripMenuItem.Checked = true;
            this.countryByGeoIPToolStripMenuItem.CheckOnClick = true;
            this.countryByGeoIPToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.countryByGeoIPToolStripMenuItem.Name = "countryByGeoIPToolStripMenuItem";
            this.countryByGeoIPToolStripMenuItem.Size = new System.Drawing.Size(167, 22);
            this.countryByGeoIPToolStripMenuItem.Text = "Country by GeoIP";
            this.countryByGeoIPToolStripMenuItem.Click += new System.EventHandler(this.countryByGeoIPToolStripMenuItem_Click);
            // 
            // selectToolStripMenuItem
            // 
            this.selectToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.allToolStripMenuItem});
            this.selectToolStripMenuItem.Name = "selectToolStripMenuItem";
            this.selectToolStripMenuItem.Size = new System.Drawing.Size(140, 22);
            this.selectToolStripMenuItem.Text = "Selection";
            // 
            // allToolStripMenuItem
            // 
            this.allToolStripMenuItem.CheckOnClick = true;
            this.allToolStripMenuItem.Name = "allToolStripMenuItem";
            this.allToolStripMenuItem.Size = new System.Drawing.Size(88, 22);
            this.allToolStripMenuItem.Text = "All";
            this.allToolStripMenuItem.Click += new System.EventHandler(this.allToolStripMenuItem_Click);
            // 
            // iPAddressesToolStripMenuItem
            // 
            this.iPAddressesToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.xHideIPs,
            this.copyToolStripMenuItem});
            this.iPAddressesToolStripMenuItem.Name = "iPAddressesToolStripMenuItem";
            this.iPAddressesToolStripMenuItem.Size = new System.Drawing.Size(140, 22);
            this.iPAddressesToolStripMenuItem.Text = "IP Addresses";
            // 
            // xHideIPs
            // 
            this.xHideIPs.CheckOnClick = true;
            this.xHideIPs.Name = "xHideIPs";
            this.xHideIPs.Size = new System.Drawing.Size(102, 22);
            this.xHideIPs.Text = "Hide";
            this.xHideIPs.Click += new System.EventHandler(this.xHideIPs_Click);
            // 
            // copyToolStripMenuItem
            // 
            this.copyToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.selectedToolStripMenuItem,
            this.allToolStripMenuItem1});
            this.copyToolStripMenuItem.Name = "copyToolStripMenuItem";
            this.copyToolStripMenuItem.Size = new System.Drawing.Size(102, 22);
            this.copyToolStripMenuItem.Text = "Copy";
            // 
            // selectedToolStripMenuItem
            // 
            this.selectedToolStripMenuItem.Name = "selectedToolStripMenuItem";
            this.selectedToolStripMenuItem.Size = new System.Drawing.Size(118, 22);
            this.selectedToolStripMenuItem.Text = "Selected";
            this.selectedToolStripMenuItem.Click += new System.EventHandler(this.selectedToolStripMenuItem_Click);
            // 
            // allToolStripMenuItem1
            // 
            this.allToolStripMenuItem1.Name = "allToolStripMenuItem1";
            this.allToolStripMenuItem1.Size = new System.Drawing.Size(118, 22);
            this.allToolStripMenuItem1.Text = "All";
            this.allToolStripMenuItem1.Click += new System.EventHandler(this.allToolStripMenuItem1_Click);
            // 
            // aboutToolStripMenuItem
            // 
            this.aboutToolStripMenuItem.Name = "aboutToolStripMenuItem";
            this.aboutToolStripMenuItem.Size = new System.Drawing.Size(52, 20);
            this.aboutToolStripMenuItem.Text = "About";
            this.aboutToolStripMenuItem.Click += new System.EventHandler(this.aboutToolStripMenuItem_Click);
            // 
            // ss
            // 
            this.ss.BackColor = System.Drawing.Color.Transparent;
            this.ss.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.lblOnline,
            this.toolStripStatusLabel2,
            this.lblPeak,
            this.toolStripStatusLabel4,
            this.lblTotal,
            this.toolStripStatusLabel1,
            this.lblSelected,
            this.toolStripStatusLabel6,
            this.lblTotalSpeed,
            this.toolStripStatusLabel5,
            this.lblFloodTimer});
            this.ss.Location = new System.Drawing.Point(0, 426);
            this.ss.Name = "ss";
            this.ss.RenderMode = System.Windows.Forms.ToolStripRenderMode.Professional;
            this.ss.Size = new System.Drawing.Size(750, 22);
            this.ss.SizingGrip = false;
            this.ss.TabIndex = 2;
            // 
            // lblOnline
            // 
            this.lblOnline.AutoSize = false;
            this.lblOnline.ForeColor = System.Drawing.Color.Black;
            this.lblOnline.Image = ((System.Drawing.Image)(resources.GetObject("lblOnline.Image")));
            this.lblOnline.Name = "lblOnline";
            this.lblOnline.Padding = new System.Windows.Forms.Padding(35, 0, 0, 0);
            this.lblOnline.Size = new System.Drawing.Size(105, 17);
            this.lblOnline.Text = "Online: 0";
            this.lblOnline.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // toolStripStatusLabel2
            // 
            this.toolStripStatusLabel2.ForeColor = System.Drawing.Color.DimGray;
            this.toolStripStatusLabel2.Name = "toolStripStatusLabel2";
            this.toolStripStatusLabel2.Size = new System.Drawing.Size(10, 17);
            this.toolStripStatusLabel2.Text = "|";
            // 
            // lblPeak
            // 
            this.lblPeak.AutoSize = false;
            this.lblPeak.ForeColor = System.Drawing.Color.Black;
            this.lblPeak.Image = ((System.Drawing.Image)(resources.GetObject("lblPeak.Image")));
            this.lblPeak.Name = "lblPeak";
            this.lblPeak.Padding = new System.Windows.Forms.Padding(35, 0, 0, 0);
            this.lblPeak.Size = new System.Drawing.Size(95, 17);
            this.lblPeak.Text = "Peak: 0";
            this.lblPeak.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // toolStripStatusLabel4
            // 
            this.toolStripStatusLabel4.ForeColor = System.Drawing.Color.DimGray;
            this.toolStripStatusLabel4.Name = "toolStripStatusLabel4";
            this.toolStripStatusLabel4.Size = new System.Drawing.Size(10, 17);
            this.toolStripStatusLabel4.Text = "|";
            // 
            // lblTotal
            // 
            this.lblTotal.AutoSize = false;
            this.lblTotal.ForeColor = System.Drawing.Color.Black;
            this.lblTotal.Image = ((System.Drawing.Image)(resources.GetObject("lblTotal.Image")));
            this.lblTotal.Name = "lblTotal";
            this.lblTotal.Padding = new System.Windows.Forms.Padding(35, 0, 0, 0);
            this.lblTotal.Size = new System.Drawing.Size(97, 17);
            this.lblTotal.Text = "Total: 0";
            this.lblTotal.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // toolStripStatusLabel1
            // 
            this.toolStripStatusLabel1.BackColor = System.Drawing.Color.Transparent;
            this.toolStripStatusLabel1.ForeColor = System.Drawing.Color.DimGray;
            this.toolStripStatusLabel1.Name = "toolStripStatusLabel1";
            this.toolStripStatusLabel1.Size = new System.Drawing.Size(10, 17);
            this.toolStripStatusLabel1.Text = "|";
            // 
            // lblSelected
            // 
            this.lblSelected.AutoSize = false;
            this.lblSelected.Image = ((System.Drawing.Image)(resources.GetObject("lblSelected.Image")));
            this.lblSelected.Name = "lblSelected";
            this.lblSelected.Padding = new System.Windows.Forms.Padding(0, 0, 30, 0);
            this.lblSelected.Size = new System.Drawing.Size(109, 17);
            this.lblSelected.Text = "Selected: 0";
            this.lblSelected.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // toolStripStatusLabel6
            // 
            this.toolStripStatusLabel6.BackColor = System.Drawing.Color.Transparent;
            this.toolStripStatusLabel6.ForeColor = System.Drawing.Color.DimGray;
            this.toolStripStatusLabel6.Name = "toolStripStatusLabel6";
            this.toolStripStatusLabel6.Size = new System.Drawing.Size(10, 17);
            this.toolStripStatusLabel6.Text = "|";
            // 
            // lblTotalSpeed
            // 
            this.lblTotalSpeed.Image = ((System.Drawing.Image)(resources.GetObject("lblTotalSpeed.Image")));
            this.lblTotalSpeed.Name = "lblTotalSpeed";
            this.lblTotalSpeed.Size = new System.Drawing.Size(107, 17);
            this.lblTotalSpeed.Text = "Total Speed: 0 B";
            // 
            // toolStripStatusLabel5
            // 
            this.toolStripStatusLabel5.Name = "toolStripStatusLabel5";
            this.toolStripStatusLabel5.Size = new System.Drawing.Size(10, 17);
            this.toolStripStatusLabel5.Text = "|";
            // 
            // lblFloodTimer
            // 
            this.lblFloodTimer.ForeColor = System.Drawing.Color.Black;
            this.lblFloodTimer.Image = ((System.Drawing.Image)(resources.GetObject("lblFloodTimer.Image")));
            this.lblFloodTimer.Name = "lblFloodTimer";
            this.lblFloodTimer.Padding = new System.Windows.Forms.Padding(10, 0, 0, 0);
            this.lblFloodTimer.Size = new System.Drawing.Size(145, 17);
            this.lblFloodTimer.Text = "Flood Timer: 00:00:00";
            // 
            // ni
            // 
            this.ni.Icon = ((System.Drawing.Icon)(resources.GetObject("ni.Icon")));
            this.ni.Text = "Net-Weave R";
            this.ni.Visible = true;
            // 
            // Main
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(774, 487);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.MainMenuStrip = this.menuStrip1;
            this.Name = "Main";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Net-Weave R";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.menuClients.ResumeLayout(false);
            this.carbonTheme1.ResumeLayout(false);
            this.panelMain.ResumeLayout(false);
            this.panelMain.PerformLayout();
            this.tabPanelMain.ResumeLayout(false);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.ss.ResumeLayout(false);
            this.ss.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panelMain;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.ColumnHeader columnHeader2;
        private System.Windows.Forms.StatusStrip ss;
        private System.Windows.Forms.ContextMenuStrip menuClients;
        private CarbonButton btnFloodPanel;
        private CarbonButton btnLog;
        private System.Windows.Forms.Panel tabPanelMain;
        private System.Windows.Forms.ColumnHeader columnHeader3;
        private System.Windows.Forms.ColumnHeader columnHeader4;
        private System.Windows.Forms.ColumnHeader columnHeader5;
        private System.Windows.Forms.ColumnHeader columnHeader6;
        private System.Windows.Forms.ColumnHeader columnHeader7;
        private CarbonButton btnSettings;
        private CarbonButton btnPlugins;
        private CarbonButton btnBuilder;
        private System.Windows.Forms.ToolStripStatusLabel lblOnline;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel2;
        private System.Windows.Forms.ToolStripStatusLabel lblPeak;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel4;
        private System.Windows.Forms.ToolStripStatusLabel lblTotal;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel6;
        private System.Windows.Forms.ImageList flags;
        private System.Windows.Forms.ToolStripStatusLabel lblFloodTimer;
        private System.Windows.Forms.MenuStrip menuStrip1;
        private System.Windows.Forms.ToolStripMenuItem menuToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem startToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem builderF2ToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem floodPanelF3ToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem pluginPanelF4ToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem settingsF5ToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem2;
        private System.Windows.Forms.ToolStripMenuItem chatF6ToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem3;
        private System.Windows.Forms.ToolStripMenuItem bugReportToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem portMapperToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem clientsToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem commandsToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem pluginsToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem downloadExecuteToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem viewToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem scrollToLatestToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem countryByGeoIPToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem selectToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem allToolStripMenuItem;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel1;
        private System.Windows.Forms.ToolStripStatusLabel lblSelected;
        private System.Windows.Forms.ToolStripMenuItem uninstallToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem4;
        private System.Windows.Forms.ToolStripMenuItem sendToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem viewToolStripMenuItem1;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem5;
        public NetLib.Forms.xListview lstClients;
        private System.Windows.Forms.ToolStripStatusLabel lblTotalSpeed;
        private System.Windows.Forms.ToolStripStatusLabel toolStripStatusLabel5;
        private System.Windows.Forms.ToolStripMenuItem iPAddressesToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem xHideIPs;
        private System.Windows.Forms.ToolStripMenuItem copyToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem selectedToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem allToolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem aboutToolStripMenuItem;
        private System.Windows.Forms.NotifyIcon ni;


    }
}