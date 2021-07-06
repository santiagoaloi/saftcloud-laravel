<template>
 <div v-if="$route.name == 'Formbuilder'">
  <v-navigation-drawer
   :key="drawerKey"
   v-model="drawer"
   :temporary="isTemporary"
   :transition="false"
   :width="300"
   app
   clipped
   right
   :mobile-breakpoint="0"
   disable-resize-watcher
   hide-overlay
   style="background: rgba(43, 54, 67, 0.9)"
  >
   <v-alert :icon="elementIcon" dark class="mb-n1 editing" tile style="background: transparent; color: white; position: relative" height="52">
    <template v-if="elementIdShortened">
     {{ elementText }}
     <v-chip disabled class="ml-3 mt-n1" small label>
      {{ elementIdShortened }}
     </v-chip>
    </template>

    <v-btn style="position: absolute; top: 10px; right: 10px" text color="white" fab x-small>
     <v-icon color="white" small @click="closeElementDrawer">
      mdi-close
     </v-icon>
    </v-btn>
   </v-alert>

   <v-tabs v-model="activeTab" height="52" fixed-tabs slider-color="#90A4AE" color="#AEB0B2" background-color="transparent">
    <v-tab> Element </v-tab>
    <v-tab :disabled="!paramsLength"> Parametrar </v-tab>
   </v-tabs>

   <base-layout-card transparent :level="4">
    <v-tabs-items v-model="activeTab">
     <v-tab-item>
      <v-row>
       <v-expansion-panels v-model="selectedPanel" flat accordion>
        <v-expansion-panel>
         <v-expansion-panel-header>Media</v-expansion-panel-header>
         <v-expansion-panel-content>
          <v-row no-gutters dense>
           <draggable
            ghost-class="ghost-card"
            class="row wrap fill-height align-center"
            handle=".my-handle"
            :options="{
             emptyInsertThreshold: 50,
             animation: 250,
             group: {
              name: 'form-builder',
              pull: 'clone',
              put: false
             }
            }"
            :list="elements"
            :clone="cloneTemplate"
            :component-data="getComponentData()"
            @start="start"
            @end="end"
           >
            <v-col v-for="(element, i) in elements" :key="i" class="my-handle" cols="12" sm="6">
             <v-card
              :elevation="element.hovered ? 5 : null"
              height="90"
              width="130"
              color="rgba(255, 245, 245, 0.1)"
              class="grabbable"
              @mouseenter="element.hovered = true"
              @mouseleave="element.hovered = false"
             >
              <v-container class="fill-height">
               <v-row class="fill-height mt-n3" align="center" justify="center">
                <v-icon size="30" class="white--text">
                 {{ element.icon }}
                </v-icon>
               </v-row>

               <v-row class="fill-height ma-0 mt-n9" align="center" justify="center">
                <small class="white--text">
                 {{ element.text }}
                </small>
               </v-row>
              </v-container>
             </v-card>
            </v-col>
           </draggable>
          </v-row>
         </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
         <v-expansion-panel-header>Formulär</v-expansion-panel-header>
         <v-expansion-panel-content>
          <v-row no-gutters dense>
           <draggable
            class="row wrap fill-height align-center sortable-list"
            handle=".my-handle"
            :options="{
             emptyInsertThreshold: 50,
             disabled: disabled,
             animation: 450,
             group: {
              name: 'form-builder',
              pull: 'clone',
              put: false
             }
            }"
            :list="forms"
            :clone="cloneTemplate"
            :component-data="getComponentData()"
            @start="start"
            @end="end"
           >
            <v-col v-for="(element, i) in forms" :key="i" class="my-handle" cols="12" sm="6">
             <v-card
              :elevation="element.hovered ? 5 : null"
              height="90"
              width="130"
              color="rgba(255, 245, 245, 0.1)"
              class="grabbable"
              @mouseenter="element.hovered = true"
              @mouseleave="element.hovered = false"
             >
              <v-container class="fill-height">
               <v-row class="fill-height mt-n3" align="center" justify="center">
                <v-icon size="30" class="white--text">
                 {{ element.icon }}
                </v-icon>
               </v-row>

               <v-row class="fill-height ma-0 mt-n9" align="center" justify="center">
                <small class="white--text">
                 {{ element.text }}
                </small>
               </v-row>
              </v-container>
             </v-card>
            </v-col>
           </draggable>
          </v-row>
         </v-expansion-panel-content>
        </v-expansion-panel>
       </v-expansion-panels>
      </v-row>
     </v-tab-item>

     <!-- PARAMETERS -->
     <v-tab-item>
      <v-card color="transparent" min-height="50vh" style="overflow: auto" class="mb-10" flat tile>
       <v-card-text v-if="Object.keys($store.state.elements.params).length">
        <v-btn depressed class="mb-2 white--text" block color="red lighten-2" @click="removeElement(elementId, elementType, elementDescription)">
         <v-icon left> mdi-delete </v-icon>
         Ta bort {{ elementDescription }}
        </v-btn>

        <template v-if="!['spacer'].includes(elementType)">
         <div class="mt-6">
          <span class="white--text">Rutnät</span>
          <v-slider v-model="elementParams.grid" :step="1" :max="12" :min="1" thumb-label ticks></v-slider>
         </div>
        </template>

        <template v-if="['video'].includes(elementType)">
         <span class="white--text"> Video Url</span> <br />
         <small class="white--text">
          Klistra in hela youtube URL:n
         </small>
         <v-text-field
          v-model="elementParams.videoId"
          v-lazy-input:debounce="200"
          prepend-inner-icon="mdi-video-box"
          dense
          solo
          background-color="#edefef"
          @focus="focusVIdeoUrl()"
         />
        </template>

        <template
         v-if="
          !['googleMap', 'layout', 'image', 'imageCarousel', 'imageMasonry', 'video', 'text', 'spacer', 'socialIcons', 'divider'].includes(
           elementType
          )
         "
        >
         <span class="white--text"> Element text</span>
         <v-text-field
          v-model="elementParams.elementText"
          v-lazy-input:debounce="200"
          prepend-inner-icon="mdi-format-text"
          dense
          solo
          background-color="#edefef"
         />
        </template>

        <template v-if="['radioGroup', 'BaseSelect', 'BaseAutocomplete', 'expansionPanel'].includes(elementType)">
         <span class="white--text"> {{ elementParams.type }} element </span>
         <v-combobox
          v-model="elementParams.multipleElements"
          v-lazy-input:debounce="200"
          dense
          solo
          :items="elementParams.multipleElements"
          :label="`${elementParams.type} elements`"
          multiple
          @blur="checkEmptyMultipleElements()"
         >
          <template v-slot:selection="{ item }">
           <div class="my-1">
            <v-chip label outlined small>
             <span>{{ item }}</span>
            </v-chip>
           </div>
          </template>
         </v-combobox>
        </template>

        <template v-if="['expansionPanel'].includes(elementType)">
         <template v-for="(text, i) in elementParams.multipleElements">
          <span :key="i" class="white--text"> Expansion panel {{ i + 1 }} text </span>
          <v-textarea :key="i" v-model="elementParams.multipleElementsParams[i]" v-lazy-input:debounce="200" class="mb-n4" dense solo />
         </template>
        </template>

        <template v-if="['socialIcons'].includes(elementType)">
         <template v-for="(icon, i) in elementParams.icons">
          <v-checkbox :key="`CHECK-${i}`" v-model="icon.visible" dark hide-details :label="icon.name" />
          <v-text-field :key="`FIELD-${i}`" v-model="icon.url" class="mt-1" solo dense hide-details="" :disabled="!icon.visible" />
         </template>
        </template>

        <template v-if="['text', 'button'].includes(elementType)">
         <span class="white--text">Textstorlek</span>
         <v-row class="mr-1 mt-n5" justify="end">
          <v-btn :ripple="false" x-small color="teal accent-3" class="ml-2" text @click.stop="elementParams.fontSize = 17">
           Återställ
          </v-btn>
         </v-row>

         <v-text-field
          v-model="elementParams.fontSize"
          v-lazy-input:debounce="200"
          color="white"
          solo
          type="number"
          dense
          hint="Påverkar all brödtext tillhörande detta element"
         />
        </template>

        <template v-if="elementType === 'text'">
         <span class="white--text">Radavstånd</span>
         <v-text-field v-model="elementParams.lineHeight" v-lazy-input:debounce="200" step=".1" color="white" solo type="number" dense />
        </template>

        <template v-if="['googleMap'].includes(elementType)">
         <span class="white--text">Address</span> <br />
         <v-text-field
          v-model="elementParams.address"
          v-lazy-input:debounce="200"
          class="black--text"
          dense
          solo
          rows="2"
          background-color="#edefef"
         />
        </template>

        <template v-if="['googleMap'].includes(elementType)">
         <span class="white--text">Zoom level</span> <br />
         <v-text-field
          v-model="elementParams.zoom"
          v-lazy-input:debounce="200"
          class="black--text"
          dense
          solo
          rows="2"
          background-color="#edefef"
          hide-details
         />
        </template>

        <template v-if="['googleMap'].includes(elementType)">
         <v-checkbox v-model="elementParams.viewControl" label="Show street view" dark hide-details />

         <v-checkbox v-model="elementParams.mapType" label="Show map type" dark />
        </template>

        <template
         v-if="
          ![
           'googleMap',
           'socialIcons',
           'image',
           'imageCarousel',
           'imageMasonry',
           'video',
           'spacer',
           'textField',
           'checkbox',
           'BaseSelect',
           'BaseSelect',
           'BaseAutocomplete'
          ].includes(elementType)
         "
        >
         <span class="white--text">Elementfärg</span>
         <v-text-field v-model="elementParams.color" v-lazy-input:debounce="200" dense solo background-color="#edefef">
          <template v-slot:append>
           <v-icon small class="mt-n1 mr-2" :color="elementParams.color">
            mdi-circle
           </v-icon>
           <v-icon @click="dialogColorPickerElementColor = true">
            mdi-format-color-fill
           </v-icon>
          </template>
         </v-text-field>
        </template>

        <template v-if="['button'].includes(elementType)">
         <v-checkbox v-model="elementParams.showBorder" class="mt-n2" :ripple="false" dark>
          <template v-slot:label>
           <span class="white--text"> Använd ram </span>
          </template>
         </v-checkbox>
        </template>

        <template v-if="['button'].includes(elementType)">
         <span class="white--text">Special Action</span>
         <v-autocomplete
          v-model="elementParams.specialAction"
          :disabled="elementParams.internalLink || elementParams.externalLink ? true : false"
          dense
          :items="['Medlem ansök']"
          solo
          small-chips
          multiple
          background-color="#edefef"
          prepend-inner-icon="mdi-gesture-tap-button"
         />
        </template>

        <template v-if="['button', 'image'].includes(elementType)">
         <span class="white--text">Internal link</span>
         <v-select
          v-model="elementParams.internalLink"
          :disabled="elementParams.specialAction.length || elementParams.externalLink ? true : false"
          clearable
          dense
          spellcheck="false"
          background-color="#edefef"
          solo
          prepend-inner-icon="mdi-link "
          hide-no-data
          :items="filteredPages"
          item-value="name"
          :menu-props="{
           transition: 'fade',
           closeOnClick: false,
           closeOnContentClick: true,
           maxHeight: 5000
          }"
         >
          <template v-slot:selection="data">
           <v-chip small>
            {{ data.item.alias }}
           </v-chip>
          </template>

          <template v-slot:item="data">
           <template>
            <v-list-item-avatar>
             <v-icon>mdi-file-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
             <v-list-item-title>
              {{ data.item.alias }}
             </v-list-item-title>
            </v-list-item-content>
           </template>
          </template>
         </v-select>
        </template>

        <template v-if="['button', 'image'].includes(elementType)">
         <span class="white--text">External link</span>
         <v-text-field
          v-model="elementParams.externalLink"
          v-lazy-input:debounce="200"
          :disabled="elementParams.specialAction.length || elementParams.internalLink ? true : false"
          placeholder="http://"
          dense
          solo
          background-color="#edefef"
          prepend-inner-icon="mdi-link "
         >
         </v-text-field>
        </template>

        <template v-if="['button'].includes(elementType)">
         <v-row no-gutters>
          <v-col sm="9">
           <span class="white--text">Icon</span>
           <v-text-field
            v-model="elementParams.appendIcon"
            v-lazy-input:debounce="600"
            placeholder="mdi-my-icon"
            dense
            solo
            background-color="#edefef"
           >
           </v-text-field>
          </v-col>
          <v-col sm="3">
           <v-btn href="https://mdisearch.com/" style="margin-top: 15px" height="39" class="ml-2" color="success" target="blank" depressed
            ><v-icon>mdi-magnify</v-icon></v-btn
           >
          </v-col>
         </v-row>
        </template>

        <template v-if="['layout'].includes(elementType)">
         <span class="white--text">Kolumn färg</span>
         <v-text-field v-model="elementParams.backgroundColor" v-lazy-input:debounce="200" dense solo background-color="#edefef">
          <template v-slot:append>
           <v-icon small class="mt-n1 mr-2" :color="elementParams.backgroundColor">
            mdi-circle
           </v-icon>
           <v-icon @click="dialogColorPickerGridColor = true">
            mdi-format-color-fill
           </v-icon>
          </template>
         </v-text-field>
        </template>

        <template v-if="['radioGroup'].includes(elementType)">
         <v-checkbox v-model="elementParams.radioColumn" class="mt-n3" dark label="Vertical layout" />
        </template>

        <template
         v-if="
          ![
           'BaseAutocomplete',
           'textArea',
           'textField',
           'socialIcons',
           'text',
           'checkbox',
           'radioGroup',
           'BaseSelect',
           'BaseSwitch',
           'expansionPanel',
           'divider'
          ].includes(elementType)
         "
        >
         <v-row no-gutters class="my-n4 mb-n2">
          <v-col class="mb-2" cols="12">
           <span class="white--text">
            {{ "Nuvarande skärmstorlek är " + calculateBreakpoint() }}
           </span>
          </v-col>

          <v-col :sm="elementType == 'layout' ? '12' : '4'">
           <span class="white--text">
            {{ elementType == "layout" ? "Minimum höjd" : "Höjd SM" }}
           </span>
           <v-text-field v-model="elementParams.heightSm" v-lazy-input:debounce="200" class="mr-1" dense solo background-color="#edefef" />
          </v-col>
          <v-col v-if="elementType != 'layout'" sm="4">
           <span class="white--text"> Höjd MD </span>
           <v-text-field v-model="elementParams.heightMd" v-lazy-input:debounce="200" class="mr-1" dense solo background-color="#edefef" />
          </v-col>

          <v-col v-if="elementType != 'layout'" sm="4">
           <span class="white--text"> Höjd LG </span>
           <v-text-field v-model="elementParams.heightLg" v-lazy-input:debounce="200" dense solo background-color="#edefef" />
          </v-col>
         </v-row>
        </template>

        <template v-if="['image'].includes(elementType)">
         <span class="white--text">Contain</span>
         <v-autocomplete v-model="elementParams.contain" dense :items="['SM', 'MD', 'LG']" solo multiple background-color="#edefef" />
        </template>

        <template v-if="['image'].includes(elementType)">
         <span class="white--text">Credits</span>
         <v-row class="mr-1 mt-n1" justify="end">
          <v-btn :ripple="false" x-small color="teal accent-3" class="ml-5 mt-n3" text @click.stop="elementParams.creditAlign = 'start'">
           Left
          </v-btn>
          <v-btn :ripple="false" x-small color="teal accent-3" class="ml-2 mt-n3" text @click.stop="elementParams.creditAlign = 'center'">
           Center
          </v-btn>
          <v-btn :ripple="false" x-small color="teal accent-3" class="ml-2 mt-n3" text @click.stop="elementParams.creditAlign = 'end'">
           Right
          </v-btn>
         </v-row>
         <v-text-field v-model="elementParams.image.metadata.credits" dense solo background-color="#edefef" />
        </template>

        <template v-if="['image', 'video'].includes(elementType)">
         <span class="white--text">Brädd</span>
         <v-row class="mr-1 mt-n5" justify="end">
          <v-btn :ripple="false" x-small color="teal accent-3" class="ml-2" text @click.stop="elementParams.width = '100%'">
           Återställ
          </v-btn>
         </v-row>
         <v-text-field v-model="elementParams.width" v-lazy-input:debounce="200" dense solo background-color="#edefef" />
        </template>

        <template
         v-if="
          ![
           'BaseAutocomplete',
           'button',
           'googleMap',
           'socialIcons',
           'spacer',
           'layout',
           'text',
           'image',
           'imageCarousel',
           'video',
           'checkbox',
           'radioGroup',
           'BaseSelect',
           'BaseSwitch',
           'expansionPanel',
           'imageMasonry',
           'divider'
          ].includes(elementType)
         "
        >
         <span class="white--text">Bakgrundsfärg</span>
         <v-text-field v-model="elementParams.backgroundColor" v-lazy-input:debounce="200" dense solo background-color="#edefef">
          <template v-slot:append>
           <v-icon small class="mt-n1 mr-2" :color="elementParams.backgroundColor">
            mdi-circle
           </v-icon>
           <v-icon style="cursor: pointer" @click="dialogBackgroundColorPicker = true">
            mdi-format-color-fill
           </v-icon>
          </template>
         </v-text-field>
        </template>

        <template v-if="['imageCarousel'].includes(elementType)">
         <v-row class="mt-n8">
          <v-col sm="4">
           <v-checkbox v-model="elementParams.cycle" :ripple="false" dark label="Cycle"> </v-checkbox>
          </v-col>
          <v-col>
           <v-text-field
            v-model="elementParams.cycleInterval"
            v-lazy-input:debounce="1500"
            suffix="miliseconds"
            :disabled="!elementParams.cycle"
            dense
            class="mt-3"
            solo
           />
          </v-col>
         </v-row>

         <div class="mt-n10">
          <v-checkbox v-model="elementParams.hideDelimiters" :ripple="false" dark label="Göm indikationspunkter" hide-details> </v-checkbox>
          <v-checkbox
           v-model="elementParams.hideDelimiterBackground"
           :ripple="false"
           dark
           label="Göm indikationspunktsbakgrunden"
           :disabled="elementParams.hideDelimiters"
           hide-details
          >
          </v-checkbox>
          <v-checkbox v-model="elementParams.showArrows" :ripple="false" dark label="Göm pilar" hide-details> </v-checkbox>
          <v-checkbox
           v-model="elementParams.showArrowsOnHover"
           :disabled="elementParams.showArrows"
           :ripple="false"
           dark
           label="Visa pilar vid svävning"
          >
          </v-checkbox>
         </div>
        </template>

        <template
         v-if="
          ![
           'BaseAutocomplete',
           'BaseSelect',
           'BaseSwitch',
           'radioGroup',
           'checkbox',
           'textArea',
           'textField',
           'image',
           'video',
           'googleMap',
           'imageCarousel',
           'socialIcons',
           'layout',
           'spacer',
           'expansionPanel',
           'divider',
           'imageMasonry'
          ].includes(elementType)
         "
        >
         <span class="white--text">Uppställning</span>
         <v-row align="center" justify="center">
          <v-col sm="12" class="text-center">
           <v-btn-toggle dense tile>
            <v-btn @click.stop="elementParams.align = 'start'">
             <v-icon>mdi-format-align-left</v-icon>
            </v-btn>
            <v-btn @click.stop="elementParams.align = 'center'">
             <v-icon>mdi-format-align-center</v-icon>
            </v-btn>
            <v-btn @click.stop="elementParams.align = 'end'">
             <v-icon>mdi-format-align-right</v-icon>
            </v-btn>
           </v-btn-toggle>
          </v-col>
         </v-row>
        </template>

        <div class="mt-5">
         <template v-if="elementType == 'layout'">
          <span class="white--text">Beskärning</span>
          <v-row class="mr-1 mt-n1" justify="end">
           <v-btn
            :ripple="false"
            x-small
            color="teal accent-3"
            class="ml-2"
            text
            @click.stop="(elementParams.cropLeft = 0), (elementParams.cropRight = 0), (elementParams.cropTop = 0), elementParams.cropBottom"
           >
            Återställ
           </v-btn>
          </v-row>

          <v-btn-toggle dense tile>
           <v-row align="center" justify="center" no-gutters dense>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.cropLeft"
              v-lazy-input:debounce="200"
              class="textCenter"
              full-width
              filled
              hide-details
              flat
              dense
             />
            </v-col>

            <v-col sm="3" class="text-center white">
             <v-text-field v-model="elementParams.cropTop" v-lazy-input:debounce="200" class="textCenter" dense full-width filled hide-details flat />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.cropBottom"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              full-width
              filled
              hide-details
              flat
             />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.cropRight"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              full-width
              filled
              hide-details
              flat
             />
            </v-col>

            <v-col sm="3" class="white"> vänster </v-col>
            <v-col sm="3" class="white"> toppen </v-col>
            <v-col sm="3" class="white"> botten </v-col>
            <v-col sm="3" class="white"> höger </v-col>
           </v-row>
          </v-btn-toggle>
          <small class="mt-2 white--text">
           Föreslagna värden (vänster, höger) är 24.
          </small>
         </template>
        </div>

        <div class="mt-5">
         <template v-if="!['layout', 'spacer'].includes(elementType)">
          <span class="white--text">Marginaler</span>
          <v-row class="mr-1 mt-n1" justify="end">
           <v-btn
            :ripple="false"
            x-small
            color="teal accent-3"
            class="ml-6 mt-n3"
            text
            @click.stop="(elementParams.ml = 0), (elementParams.mt = 0), (elementParams.mb = 0), elementParams.mr"
           >
            Återställ
           </v-btn>
          </v-row>

          <v-btn-toggle dense tile>
           <v-row align="center" justify="center" no-gutters dense>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.ml"
              v-lazy-input:debounce="200"
              type="number"
              class="textCenter"
              full-width
              filled
              hide-details
              flat
              dense
             />
            </v-col>

            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.mt"
              v-lazy-input:debounce="200"
              class="textCenter"
              type="number"
              dense
              full-width
              filled
              hide-details
              flat
             />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.mb"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              type="number"
              full-width
              filled
              hide-details
              flat
             />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.mr"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              type="number"
              full-width
              filled
              hide-details
              flat
             />
            </v-col>

            <v-col sm="3" class="white"> vänster </v-col>
            <v-col sm="3" class="white"> toppen </v-col>
            <v-col sm="3" class="white"> botten </v-col>
            <v-col sm="3" class="white"> höger </v-col>
           </v-row>
          </v-btn-toggle>
         </template>
        </div>

        <div class="mt-5">
         <template v-if="!['layout', 'spacer'].includes(elementType)">
          <span class="white--text">Padding</span>
          <v-row class="mr-1 mt-n1" justify="end">
           <v-btn
            :ripple="false"
            x-small
            color="teal accent-3"
            class="ml-6 mt-n3"
            text
            @click.stop="(elementParams.pt = 0), (elementParams.pl = 0), (elementParams.pb = 0), elementParams.pr"
           >
            Återställ
           </v-btn>
          </v-row>
          <v-btn-toggle dense tile>
           <v-row align="center" justify="center" no-gutters dense>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.pl"
              v-lazy-input:debounce="200"
              type="number"
              class="textCenter"
              full-width
              filled
              hide-details
              flat
              dense
             />
            </v-col>

            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.pt"
              v-lazy-input:debounce="200"
              class="textCenter"
              type="number"
              dense
              full-width
              filled
              hide-details
              flat
             />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.pb"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              type="number"
              full-width
              filled
              hide-details
              flat
             />
            </v-col>
            <v-col sm="3" class="text-center white">
             <v-text-field
              v-model="elementParams.pr"
              v-lazy-input:debounce="200"
              class="textCenter"
              dense
              type="number"
              full-width
              filled
              hide-details
              flat
             />
            </v-col>

            <v-col sm="3" class="white"> vänster </v-col>
            <v-col sm="3" class="white"> toppen </v-col>
            <v-col sm="3" class="white"> botten </v-col>
            <v-col sm="3" class="white"> höger </v-col>
           </v-row>
          </v-btn-toggle>
         </template>
        </div>

        <!-- <template v-if="!['layout', 'spacer', ].includes(elementType)">
              <span class="white--text">Marginaler</span>
              <v-btn
                :ripple="false"
                x-small
                color="teal lighten-2"
                class="ml-2"
                text
                @click.stop="elementParams.ml = 0, elementParams.mt = 0 ">
                Noll
              </v-btn>
              <v-btn
                :ripple="false"
                x-small
                color="teal lighten-2"
                class="ml-2"
                text
                @click.stop="elementParams.ml = 0, elementParams.mt = 30 ">
                Standard
              </v-btn>

              <v-btn-toggle
                dense
                tile>
                <v-row
                  align="center"
                  justify="center"
                  no-gutters
                  dense>
                  <v-col
                    sm="3"
                    class="text-center white">
                    <v-text-field
                      v-model="elementParams.ml"
                      class="textCenter"
                      full-width
                      filled
                      hide-details
                      flat
                      dense
                    />
                  </v-col>

                  <v-col
                    sm="3"
                    class="text-center white">
                    <v-text-field
                      v-model="elementParams.mt"
                      dense
                      full-width
                      filled
                      hide-details
                      flat
                    />
                  </v-col>
                  <v-col
                    sm="3"
                    class="text-center white">
                    <v-text-field
                      v-model="elementParams.mt"
                      dense
                      full-width
                      filled
                      hide-details
                      flat
                    />
                  </v-col>
                  <v-col
                    sm="3"
                    class="text-center white">
                    <v-text-field
                      v-model="elementParams.ml"
                      dense
                      full-width
                      filled
                      hide-details
                      flat
                    />
                  </v-col>

                  <v-col
                    sm="3"
                    class="text-center white">
                    <v-btn
                      depressed
                      small
                      tile
                      block
                      @mousedown="startHoldNegative(elementParams, 'ml')"
                      @mouseleave="stopHold"
                      @mouseup="stopHold"
                      @touchstart="startHoldNegative(elementParams, 'ml')"
                      @touchend="stopHold"
                      @touchcancel="stopHold">
                      <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                  </v-col>
                  <v-col
                    sm="3"
                    class="text-center">
                    <v-btn
                      depressed
                      small
                      tile
                      block
                      @mousedown="startHoldNegative(elementParams, 'mt')"
                      @mouseleave="stopHold"
                      @mouseup="stopHold"
                      @touchstart="startHoldNegative(elementParams, 'mt')"
                      @touchend="stopHold"
                      @touchcancel="stopHold">
                      <v-icon>mdi-chevron-up</v-icon>
                    </v-btn>
                  </v-col>
                  <v-col
                    sm="3"
                    class="text-center">
                    <v-btn
                      depressed
                      small
                      tile
                      block
                      @mousedown="startHoldPositive(elementParams, 'mt')"
                      @mouseleave="stopHold"
                      @mouseup="stopHold"
                      @touchstart="startHoldPositive(elementParams, 'mt')"
                      @touchend="stopHold"
                      @touchcancel="stopHold">
                      <v-icon>mdi-chevron-down</v-icon>
                    </v-btn>
                  </v-col>
                  <v-col
                    sm="3"
                    class="text-center">
                    <v-btn
                      depressed
                      small
                      tile
                      block
                      @mousedown="startHoldPositive(elementParams, 'ml')"
                      @mouseleave="stopHold"
                      @mouseup="stopHold"
                      @touchstart="startHoldPositive(elementParams, 'ml')"
                      @touchend="stopHold"
                      @touchcancel="stopHold">
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-btn-toggle>

              <template v-if="!['video'].includes(elementType)">
                <span class="white--text">Avstånd</span>
                <v-btn
                  :ripple="false"
                  x-small
                  color="teal lighten-2"
                  class="ml-2"
                  text
                  @click.stop="elementParams.pl = 10, elementParams.pt = 0 ">
                  Återställ avstånd
                </v-btn>
                <v-row
                  align="center"
                  justify="center">
                  <v-col
                    sm="12"
                    class="text-center">
                    <v-btn-toggle
                      dense
                      rounded>
                      <v-btn
                        @mousedown="startHoldNegative(elementParams, 'pl')"
                        @mouseleave="stopHold"
                        @mouseup="stopHold"
                        @touchstart="startHoldNegative(elementParams, 'pl')"
                        @touchend="stopHold"
                        @touchcancel="stopHold">
                        <v-icon>mdi-chevron-left</v-icon>
                      </v-btn>
                      <v-btn
                        @mousedown="startHoldNegative(elementParams, 'pt')"
                        @mouseleave="stopHold"
                        @mouseup="stopHold"
                        @touchstart="startHoldNegative(elementParams, 'pt')"
                        @touchend="stopHold"
                        @touchcancel="stopHold">
                        <v-icon>mdi-chevron-up</v-icon>
                      </v-btn>
                      <v-btn
                        @mousedown="startHoldPositive(elementParams, 'pt')"
                        @mouseleave="stopHold"
                        @mouseup="stopHold"
                        @touchstart="startHoldPositive(elementParams, 'pt')"
                        @touchend="stopHold"
                        @touchcancel="stopHold">
                        <v-icon>mdi-chevron-down</v-icon>
                      </v-btn>
                      <v-btn
                        @mousedown="startHoldPositive(elementParams, 'pl')"
                        @mouseleave="stopHold"
                        @mouseup="stopHold"
                        @touchstart="startHoldPositive(elementParams, 'pl')"
                        @touchend="stopHold"
                        @touchcancel="stopHold">
                        <v-icon>mdi-chevron-right</v-icon>
                      </v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>
              </template>
            </template> -->
       </v-card-text>
      </v-card>
     </v-tab-item>
    </v-tabs-items>
   </base-layout-card>

   <v-footer color="rgba(43, 54, 67, 0.7)" absolute>
    <v-icon dark v-ripple style="cursor: pointer" @click="isTemporary = !isTemporary">
     mdi-dock-window
    </v-icon>
    <v-icon dark v-ripple class="ml-3" style="cursor: pointer" @click="changeElementFramesVisibility()">
     mdi-eye
    </v-icon>
   </v-footer>
  </v-navigation-drawer>

  <v-dialog v-model="dialogColorPickerElementColor" width="300px" :transition="false" style="overflow: hidden" hide-overlay>
   <v-color-picker v-if="dialogColorPickerElementColor" v-model="elementParams.color" v-lazy-input:debounce="100" mode="hexa" />
  </v-dialog>

  <v-dialog v-model="dialogColorPickerGridColor" width="300px" :transition="false" style="overflow: hidden" hide-overlay>
   <v-color-picker v-if="dialogColorPickerGridColor" v-model="elementParams.backgroundColor" v-lazy-input:debounce="100" mode="hexa" />
  </v-dialog>

  <v-dialog v-model="dialogBackgroundColorPicker" width="300px" :transition="false" style="overflow: hidden" hide-overlay>
   <v-color-picker v-if="dialogBackgroundColorPicker" v-model="elementParams.backgroundColor" v-lazy-input:debounce="100" mode="hexa" />
  </v-dialog>
 </div>
</template>

<script>
import { store } from "@/store";
import { mapActions } from "vuex";
import { v4 as uuidv4 } from "uuid";
import { forms, elements } from "@/util/dynamicElements";
import draggable from "vuedraggable";
import pages from "@/router/public";

export default {
 name: "ElementDrawer",
 components: {
  draggable
 },

 filters: {
  capitalize: function(value) {
   if (!value) return "";
   value = value.toString();
   return value.charAt(0).toUpperCase() + value.slice(1);
  }
 },

 data() {
  return {
   isTemporary: false,
   drawerKey: 129383883,
   interval: false,
   dialogColorPickerElementColor: false,
   dialogColorPickerGridColor: false,
   dialogBackgroundColorPicker: false,
   grid: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
   activeTab: 0,
   id: 6,
   selectedPanel: 1,
   disabled: false,
   forms: Object.keys(forms).map(key => forms[key]),
   elements: Object.keys(elements).map(key => elements[key]),
   miniVariant: "",
   drawer: false
  };
 },

 computed: {
  filteredPages: function() {
   return pages.filter(item => {
    return item.meta.editable || item.alias === "Portfolio";
   });
  },

  paramsLength() {
   return store.state.elements.params.length;
  },

  currentRoute() {
   return this.$route.name;
  },

  elementText() {
   return store.state.elements.element.text;
  },

  elementIcon() {
   return store.state.elements.element.icon;
  },

  elementId() {
   if (store.state.elements.element == "") {
    return null;
   }
   return store.state.elements.element.id;
  },

  elementIdShortened() {
   if (store.state.elements.element == "") {
    return null;
   }
   return store.state.elements.element.id.substring(0, 4);
  },

  elementType() {
   return store.state.elements.element.type;
  },

  elementDescription() {
   return store.state.elements.element.description;
  },

  elementParams() {
   return store.state.elements.params;
  }
 },

 watch: {
  "elementParams.specialAction"(val, newVal) {
   if (!val) return;
   return (this.elementParams.externalLink = ""), (this.elementParams.internalLink = undefined);
  },

  "elementParams.internalLink"(val, newVal) {
   if (!val) return;
   return (this.elementParams.externalLink = ""), (this.elementParams.specialAction = "");
  },

  "elementParams.externalLink"(val, newVal) {
   if (!val) return;
   return (this.elementParams.internalLink = undefined), (this.elementParams.specialAction = "");
  }
 },

 destroyed() {
  // window.getApp.$off('APP_EL_DRAWER_TOGGLED')
  window.getApp.$off("APP_UPDATE_ELEMENT_TEXT_VALUE");
  window.getApp.$off("APP_ELEMENT_DRAWER_PARAMS");
 },

 mounted() {
  this.$store.commit("SET_elementFramesEnabled");

  window.getApp.$on("APP_EL_DRAWER_TOGGLED", () => {
   this.drawer = !this.drawer;
  });

  window.getApp.$on("APP_UPDATE_ELEMENT_TEXT_VALUE", value => {
   this.elementParams.elementText = value;
   this.save();
  });

  window.getApp.$on("APP_ELEMENT_DRAWER_ELEMENTS", () => {
   this.activeTab = 0;
  });

  window.getApp.$on("APP_ELEMENT_DRAWER_PARAMS", () => {
   this.refreshDrawer();
   this.drawer = true;
   this.activeTab = 1;
   // this.clearElementParams()
  });
 },

 methods: {
  ...mapActions(["saveElementParams", "clearElementParams", "setElementFrames"]),

  checkEmptyMultipleElements() {
   if (!this.elementParams.multipleElements.length) {
    this.elementParams.multipleElements.push("Title");
   }
  },

  closeElementDrawer() {
   window.getApp.$emit("APP_EL_DRAWER_TOGGLED");
  },

  calculateBreakpoint() {
   if (this.$vuetify.breakpoint.smAndDown) {
    return "Small";
   }
   if (this.$vuetify.breakpoint.md) {
    return "Medium";
   }
   if (this.$vuetify.breakpoint.mdAndUp) {
    return "Large";
   }
  },

  // onFilePicked(e) {
  //   const files = e.target.files;

  //   if (files[0] !== undefined) {
  //     const size = files[0].size;

  //     const fr = new FileReader();

  //     fr.readAsDataURL(files[0]);
  //     fr.addEventListener("load", () => {
  //       // Hardcoded max 2MB upload limit
  //       if (size > 2 * 1024 * 1024) {
  //         alert(
  //           "Högsta tillåtna bildstorleken är 2MB, denna bilden är för stor."
  //         );
  //       } else {
  //         this.elementParams.images.push({
  //           image: fr.result,
  //           metadata: { credits: "" }
  //         });
  //       }
  //     });
  //   }
  // },

  focusVIdeoUrl() {
   window.getApp.$emit("APP_ELEMENT_FORCE_KEYCHANGE");
  },

  changeElementFramesVisibility() {
   this.setElementFrames();
  },

  removeElement(id, type, description) {
   window.getApp.$emit("APP_DRAG_REMOVE_ELEMENT", id, type, description);
  },

  refreshDrawer() {
   this.drawerKey++;
  },

  startHoldNegative(el, value) {
   if (!this.interval) {
    this.interval = setInterval(() => el[value]--, 30);
    if (el[value] < 0) {
     el[value] = 0;
    }
   } else {
    this.interval = setInterval(() => el[value]--, 30);
   }
  },

  startHoldPositive(el, value) {
   if (!this.interval) {
    this.interval = setInterval(() => el[value]++, 30);
    if (el[value] < 0) {
     el[value] = 0;
    }
   } else {
    this.interval = setInterval(() => el[value]++, 30);
   }
  },

  stopHold() {
   clearInterval(this.interval);
   this.interval = false;
  },

  save() {
   var params = this.elementParams;
   this.saveElementParams({ params });
  },

  start() {
   window.getApp.$emit("APP_DRAG_DISABLE_CONTAINER_NESTED");
   window.getApp.$emit("APP_DRAG_INCREASE_DROPZONE_HEIGHT");
  },

  end() {
   window.getApp.$emit("APP_DRAG_ENABLE_CONTAINER_NESTED");
   window.getApp.$emit("APP_DRAG_DECREASE_DROPZONE_HEIGHT");
  },

  cloneTemplate(element) {
   return {
    id: uuidv4(),
    type: element.type,
    typeDescription: element.typeDescription,
    componentName: element.componentName,
    text: element.text,
    icon: element.icon,
    hovered: false,
    options: { ...element.options },
    children: []
   };
  },
  getComponentData() {
   return {
    attrs: {
     class: "group templates"
    }
   };
  }
 }
};
</script>
<style scoped>
.v-alert {
 font-size: 12px;
}

::v-deep .theme--light.v-messages {
 color: #ccc;
}

::v-deep .v-label {
 font-size: 12px;
}

::v-deep .textCenter input {
 text-align: center;
}

.borderRight {
 border-right-style: dotted;
 border-right-width: 1px;
}

.ghost-card {
 opacity: 0.2;
 zoom: 0.8;
 background: #f7fafc;
 margin: 20px;
 padding: 10px;
}

::v-deep .v-alert__icon.v-icon {
 color: #fff;
}
.grabbable {
 cursor: move; /* fallback if grab cursor is unsupported */
 cursor: grab;
 cursor: -moz-grab;
 cursor: -webkit-grab;
}

/* (Optional) Apply a "closed-hand" cursor during drag operation. */
.grabbable:active {
 cursor: grabbing;
 cursor: -moz-grabbing;
 cursor: -webkit-grabbing;
}

.theme--light.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active),
.theme--light.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active) > .v-icon,
.theme--light.v-tabs > .v-tabs-bar .v-tab:not(.v-tab--active) > .v-btn,
.theme--light.v-tabs > .v-tabs-bar .v-tab--disabled {
 color: unset;
}

.theme--light.v-tabs-items {
 background-color: transparent;
}

.v-expansion-panel-content {
 background: transparent;
}

.v-application--is-ltr .v-expansion-panel-header {
 background: transparent;
 color: white;
}

.theme--light.v-expansion-panels .v-expansion-panel {
 background-color: transparent;
}

::v-deep .v-list-item {
 padding: 0 7px;
}

.v-application--is-ltr .v-list-group--no-action > .v-list-group__items > .v-list-item {
 padding-left: 14px !important;
}

.rounded {
 width: 100px !important;
 height: 100px !important;
 position: relative;
 overflow: hidden;
 border-radius: 50%;
 z-index: 999999 !important;
 margin-top: -1em !important;
 margin-left: 4.5em !important;
 margin-bottom: 1em !important;
}

::v-deep .v-navigation-drawer {
 transition-duration: 0.05s !important;
 transition-timing-function: linear;
}

.shadows {
 text-shadow: rgba(61, 61, 61, 0.1) 1px 1px, rgba(149, 207, 245, 0.3) 1px 1px;
}
</style>
