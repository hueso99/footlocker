using NetLib.Forms;
namespace Net_Weave_R.Forms.Dialogs
{
    partial class IconSelecterDialog
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
            this.lstIcons = new xListview();
            this.toolTip1 = new System.Windows.Forms.ToolTip(this.components);
            this.SuspendLayout();
            // 
            // lstIcons
            // 
            this.lstIcons.Dock = System.Windows.Forms.DockStyle.Fill;
            this.lstIcons.Location = new System.Drawing.Point(0, 0);
            this.lstIcons.Name = "lstIcons";
            this.lstIcons.Size = new System.Drawing.Size(284, 262);
            this.lstIcons.TabIndex = 0;
            this.toolTip1.SetToolTip(this.lstIcons, "Double-Click to select icon.");
            this.lstIcons.UseCompatibleStateImageBehavior = false;
            this.lstIcons.DoubleClick += new System.EventHandler(this.lstIcons_DoubleClick);
            // 
            // IconSelecterDialog
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(284, 262);
            this.Controls.Add(this.lstIcons);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.MaximizeBox = false;
            this.Name = "IconSelecterDialog";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Select Icon";
            this.ResumeLayout(false);

        }

        #endregion

        private xListview lstIcons;
        private System.Windows.Forms.ToolTip toolTip1;

    }
}