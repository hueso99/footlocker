using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using NetLib.API;
using NetLib.Forms.API;
namespace Net_Weave_R.Misc
{
    class FormFader
    {
        public static void Fade(Form form, bool fadeIn)
        {
            if (fadeIn)
                User32.AnimateWindow(form.Handle, 500, User32.AW_ACTIVATE | User32.AW_BLEND);
            else
                User32.AnimateWindow(form.Handle, 500, User32.AW_HIDE | User32.AW_BLEND);
            //protected override void OnLoad(EventArgs e)
            //{
            //    base.OnLoad(e);
            //    User32.AnimateWindow(this.Handle, 1000, AW_ACTIVATE | (_UseSlideAnimation ?
            //                  AW_HOR_POSITIVE | AW_SLIDE : AW_BLEND));
            //}
            //protected override void OnClosing(System.ComponentModel.CancelEventArgs e)
            //{
            //    base.OnClosing(e);
            //    if (e.Cancel == false)
            //    {
            //        AnimateWindow(this.Handle, 1000, AW_HIDE | (_UseSlideAnimation ?
            //                      AW_HOR_NEGATIVE | AW_SLIDE : AW_BLEND));
            //    }
            //}
        }
    }
}
