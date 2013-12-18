using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Net_Weave_R.Misc
{
    public class IAssembly
    {
        public string Title;
        public string Description;
        public string Configuration;
        public string Company;
        public string Copyright;
        public string Trademark;
        public string Culture;
        public string Guid;
        public string AssemblyVersion;
        public string AssemblyFileVersion;
        public string IconPath;
        public IAssembly(string title,
            string description,
            string configuration,
            string company,
            string copyright,
            string trademark,
            string culture,
            string guid,
            string assemblyVersion,
            string assemblyFileVersion,
            string iconPath)
        {
            Title = title;
            Description = description;
            Configuration = configuration;
            Company = company;
            Copyright = copyright;
            Trademark = trademark;
            Culture = culture;
            Guid = guid;
            AssemblyVersion = assemblyFileVersion;
            AssemblyFileVersion = assemblyFileVersion;
            IconPath = iconPath;
        }
    }
}
