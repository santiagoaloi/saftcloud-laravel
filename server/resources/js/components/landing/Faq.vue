<template>
  <div>
    <div v-for="faq in faqs" :id="faq.id" :key="faq.id">
      <div id="#general" class="title pl-2 pb-2 mt-15">
        {{ faq.title }}
      </div>
      <v-expansion-panels class="mb-4" multiple>
        <v-expansion-panel v-for="(item, i) in faq.items" :key="i">
          <v-expansion-panel-header class="font-weight-black">
            {{ item.title }}
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            {{ item.content }}
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
  </div>
</template>

<script>
  /*
|---------------------------------------------------------------------
| Help Page Component
|---------------------------------------------------------------------
|
| Template to show frequently asked questions to your users
|
*/
  export default {
    data() {
      return {
        search: '',

        breadcrumbs: [
          {
            text: 'Pages',
            disabled: false,
            href: '#',
          },
          {
            text: 'FAQ',
          },
        ],

        faqs: [
          {
            id: 'general',
            title: 'General Resources',
            items: [
              {
                title:
                  'Can I use a purchased item in a freelance project or contract work for a client?',
                content:
                  'Yes. However, if the client intends to charge End Users in any way from the End Product you create, you will need to purchase an Extended License. If you create the End Product for a client, your rights to purchased Items are transferred from you to your client.',
              },
              {
                title: 'What is an End Product?',
                content:
                  'An End Product is work that is designed or developed for a single, paid client. This website can not be resold as a product to multiple users. For more information on selling products to multiple users.',
              },
              {
                title: 'What are the End Product requirements?',
                content:
                  'An End Product must be a unique implementation of the Item, often requiring limited copy and content changes. For example, if you purchase a resume template, you may use the Item for yourself or a client after having input personal information (you may not resell it as stock).',
              },
              {
                title: 'What is Personal Use, Commerical Work, Contracted Work, Client Work, etc.?',
                content:
                  'If the created site can not charge users in any way, it is considered for Personal Use and a Regular License can be used. For End Products that can charge users, such as a Software as a Service application, or an e-commerce site, you should use an Extended License. For any End Products that will be sold in its entirety, such as creating software that is distributed digitally, use an Unlimited License.',
              },
              {
                title: 'What is Personal Use?',
                content:
                  'A Personal Use License can only be used for 1 End Product that does not charge users in any way.',
              },
              {
                title: 'What is Commerical Use?',
                content:
                  'A Commercial Use License can only be used for 1 End Product that charges or will charge users.',
              },
              {
                title: 'What is Unlimited Use?',
                content:
                  'An Extended Use License can be used for any number of Personal and Commercial projects.',
              },
            ],
          },
        ],
      };
    },
  };
</script>
