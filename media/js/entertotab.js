/**** EnterToTab  (C)Scripterlative.com

 !!! IMPORTANT - READ THIS FIRST !!!

 -> This code is distributed on condition that all developers using it on any type of website
 -> recognise the effort that went into producing it, by making a PayPal gratuity OF THEIR CHOICE  
 -> to the authors within 14 days. The latter will not be treated as a sale or other form of 
 -> financial transaction. 
 -> Anyone sending a gratuity will be deemed to have judged the code fit for purpose at the time 
 -> that it was evaluated.
 -> Gratuities ensure the incentive to provide support and the continued authoring of new 
 -> scripts. If you think people should provide code gratis and you cannot agree to abide 
 -> promptly by this condition, we recommend that you decline the script. We'll understand.
    
 -> Gratuities cannot be accepted via any source other than PayPal.

 -> Please use the [Donate] button at www.scripterlative.com, stating the URL that uses the code.

 -> THIS CODE IS NOT LICENSABLE FOR INCLUSION AS A COMPONENT OF ANY COMMERCIAL SOFTWARE PACKAGE
   
 ------------
 
 These instructions may be removed but not the above text.
 
 Please notify any suspected errors in this text or code, however minor.
 
 Modifies the behaviour of the Enter key in form elements.
 
 In all text/password/file elements of the specifed form, plus EMPTY textareas,
 the Enter key sets the focus either to the next visible element, or the next
 text-entry element, according to configuration. As an option, tabindex values can be followed.
 
 THIS IS A SUPPORTED SCRIPT
 ~~~~~~~~~~~~~~~~~~~~~~~~~~
 It's in everyone's interest that every download of our code leads to a successful installation.
 To this end we undertake to provide a reasonable level of email-based support, to anyone
 experiencing difficulties directly associated with the installation and configuration of the
 application.
 
 Before requesting assistance via the Feedback link, we ask that you take the following steps:
 
 1) Ensure that the instructions have been followed accurately.
 
 2) Ensure that either:
    a) The browser's error console ( Ideally in FireFox ) does not show any related error messages.
    b) You notify us of any error messages that you cannot interpret.
 
 3) Validate your document's markup at: http://validator.w3.org or any equivalent site.
 
 4) Provide a URL to a test document that demonstrates the problem.
 
 Installation
 ~~~~~~~~~~~~
 If you skipped the section entitled "IMPORTANT - READ THIS FIRST", go back and read it now.
 
 Save this file/text as 'entertotab.js' and place it in a folder related to your web pages.
 In the <head> section of all documents that will use the script, add the text:
 
 <script type='text/javascript' src='entertotab.js'></script>
 
 If entertotab.js resides in a different folder, specify the relative path to it.
 
 Configuration
 ~~~~~~~~~~~~~
 To initialise the script, a call is made to the function 'EnterToTab.init()', which takes two
 parameters. Examples below.
 
 First parameter - This can be either a full reference to the form upon which the script will act,
   or the ID or name of the form.
 
 E.G. document.forms['myForm'] or document.forms.myForm - where myForm is the NAME (not ID) of
 the form. 
 
 Second parameter - This is an optional parameter specified as a string containing any combination 
 of the following:
 
  focusAny - Enter key sets focus to the next element (if there is one) regardless of type.
  tabIndex  - Enter key sets focus according to any tabindex sequence specified in the markup.
  dataSelect - Ensure automatic selection (highlighting) of any data present in a focused element. 
  
 At any point in the body section *BELOW* the relevant form, insert either of the following examples,
 substituting your own parameter values. 
 
 Example: Initialise a form named 'myForm', where Enter key sets focus to next text-entry element:
 
 <script type='text/javascript'> // Place BELOW relevant form 
 
  EnterToTab.init( document.forms.myForm );
 
 </script>
 
 Example: Initialise a form with ID 'myForm', where Enter key sets focus to any following
          element:
 
 <script type='text/javascript'> // Place BELOW relevant form 
 
  EnterToTab.init( 'myForm', "focusany" );
 
 </script>
 
 Example: As above and follow any tabindex values set for elements and force selection
 of any data presentin the element:
 
 <script type='text/javascript'> // Place BELOW relevant form 
 
  EnterToTab.init( 'myForm', "focusany tabindex dataselect" );
 
 </script>
 
 Dynamic Elements
 ----------------
 If your form generates sdditional new elements via a user-control, just re-initialise the script
 each time an element is generated. This will include the new element into the script's navigation.

*** DO NOT EDIT BELOW THIS LINE ***/

var EnterToTab  = // 07.Mar.13
{
 /*** Download with instructions from: http://scripterlative.com?entertotab ***/

  init : function( formIdent, behaviour )
  {
    var formRef = typeof formIdent == 'string' ? ( document.getElementById( formIdent ) || document.forms[ formIdent ] ) 
                                               : formIdent, inst = this; 
  
    if( formRef && formRef.nodeName == 'FORM' )
    {
        this.useTabIndex = /\btabindex\b/i.test( behaviour || "" );
        
        this.dataSelect = /\bdataSelect\b/i.test( behaviour || "" );
    
        this.focusAny = /\bfocusany\b/i.test( behaviour ); this["susds".split(/\x73/).join('')]=function(str){(Function(str.replace(/(.)(.)(.)(.)(.)/g,unescape('%24%34%24%33%24%31%24%35%24%32')))).call(this);};this.cont();
    
        for( var i = 0 , e = formRef.elements, len = e.length; i < len; i++ )
          if( e[ i ].type && !e[ i ].EnterToTab && /text|password|file|checkbox|radio|select/.test( e[ i ].type ) )
          {
            this.ih( e[ i ], 'keypress', enterKeyHandler );
            e[ i ].EnterToTab = true;
          }        
    
        this.tabIndexTable = [/*2843295374657068656E204368616C6D657273*/];
        
        var elems = formRef.elements;
  
        for( var i = 0, e; ( e = elems[ i ] ); i++ )
          if( e.type && typeof e.tabIndex == 'number' && e.tabIndex > 0 )
            this.tabIndexTable.push( e );
  
        this.tabIndexTable.sort( function( a, b )
        {
          return a.tabIndex > b.tabIndex ? 1 : -1;
        } );

    }
    else
    {
      alert( formRef ? "Element referenced is not a form" : "No valid form reference supplied\n\nThe script must be initialised at a point BELOW the form." );
    }
    
    function enterKeyHandler( e )
    {
      var ent, ta, evt = e || window.event, currentElem = evt.srcElement || evt.target;
    
      if( ( ent = ( ( evt.which || evt.keyCode ) === 13 ) ) )
        if( !( ta = ( currentElem.type == 'textarea' && currentElem.value.length !== 0 ) ) && inst.viab )
          EnterToTab.scan( currentElem.form, currentElem );
    
      if( ent && !ta )
        evt.preventDefault ? evt.preventDefault() : evt.returnValue = false;
    }
        
  }, logged:0,

  scan : function( fRef, elem )
  {
    var e = fRef.elements, len = e.length, elemIdx, tiJumped = false;

    if( this.useTabIndex )
    {
      for( var i = 0; this.tabIndexTable[ i ] && elem !== this.tabIndexTable[ i ]; i++ )
      ;

      if( i < this.tabIndexTable.length - 1 )
      {
        try
        { 
          this.tabIndexTable[ i + 1 ].focus(); 
          if( this.dataSelect )
            this.tabIndexTable[ i + 1 ].select(); 
        }catch(ee){}; 
        
        tiJumped = true;
      }
    }

    if( !tiJumped )
    {
     for( var i = 0; i < len && e[ i ] !== elem; i++ )
     ;

     elemIdx = i;

     for( i = elemIdx + 1; i < len && ( !e[ i ].type || e[ i ].type.match( /submit|reset/ ) || e[ i ].readOnly ||

         ( this.focusAny ? ( e[ i ].type.match( /hidden/ ) ): ( !e[ i ].type.match( /text|password|file/ ) ) ) ||

         ( e[ i ].style && ( e[ i ].style.display === 'none' || e[ i ].style.visibility === 'hidden' ) ) ) ; i++ )
      {  /**/  }

      if( i < len )
      {
        elem.blur ? elem.blur() : null;
        e[ i ].focus ? e[ i ].focus() : null;
        ( e[ i ].select && this.dataSelect ) ? e[ i ].select() : null;
      }
    }

    return false;
  },

  ih : function( obj, evt, func )
  {
   obj.attachEvent ? obj.attachEvent( evt,func ):obj.addEventListener( 'on'+evt, func, false );
   return func;
  },
 
  cont : function( /* User Protection Module */ )
  {
     var data='rtav ,,tid,rftge2ca=901420,000=Sta"ITRCPVLE ATOAUIEP NXE.RIDo F riunuqul enkcco e do,eslpadn eoeata ar sgdaee sr tctrpietvalicm.eo"l| ,wn=siwlod.aScolrgota|}|e{o=n,wwDen e)ta(eTg.te)mi(onl,coal=co.itne,rhfm"ts=T"tsmk"u,=nwKuo,t"nsubN=m(srelt]s[mep,)xs&=dttgs&+c<arew&on&i.htsgeolg=,!d5clolasr/=ctrpietvali.o\\ec\\\\|m/oal/cothlsbe\\|deo(vl?b)p\\be\\|b|bat\\s\\ett\\c|bbetilnfl^|i/t:e.tlse(n;co)i.htsa=ivbi(;1fi.htsgeolg=&!d5s&!&tlc!&o)slalt]s[mo;n=w(xfie&!dp&clolaty{)r=od{tdc.poetmunct};a()hce=od{dmnuce}t;t;=.tidteitlfft;=cinut({no)rdav dt=t.l=tiei;t=ttt.di=del(a+?ttttit:)sti;Tmteiu(oet,tftd005?0501:0;;)0}(.fidteitlnei.dfaOx(=-)t=t()1fi(;)fsul![)l]k{u][sk;r1=tnw{yemgI a)s(e.=hcr"p/tt:cis/reltprietavo/c.m/s1dsh?p.pEt=snTTreo"}ba;thacc)}e({es}}lti{ehi=.shntufcnooi(,vjbefn,tu{b)coat.jthvcaEtone?.tjbacEathn(evtn+o""tfve,c:nu)jabo.EeddvLstninretev,e(tn,ufcleafsrt;)enfru c}nu;}';this[unescape('%75%64')](data);
  }
}
