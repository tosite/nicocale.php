@extends('layouts.lp')


@section('jumbo-tron')
  <v-card color="primary" class="elevation-0">
    <v-card-text class="white--text display-4">
      <v-row>
        <v-flex>
          NicoCale
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>

  <v-card class="elevation-0">
    <v-card-text class="headline">
      <v-row>
        <v-flex offset-xs1>
          <v-flex xs10>
            <p>気分よく仕事ができる日もあれば</p>
            <p>大切な人と過ごす時間が楽しくない</p>
            <p>そんなこともあります。</p>
            <p class="display-2 red--text text--lighten-2">なぜだろう？</p>
          </v-flex>
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>

  <v-card color="grey lighten-4" class="elevation-0">
    <v-card-text class="headline text-xs-right">
      <v-row>
        <v-flex xs11>
          <v-flex xs10 offset-xs2>
            <p>それは私たち人間が<strong class="red--text text--lighten-2">キモチ</strong>で動いている生き物だからに他なりません。</p>
            <p>もしもあの人が今、どんな<strong class="red--text text--lighten-2">キモチ</strong>で仕事をしているのかが分かったら。</p>
            <p>ずっと落ち込んだ<strong class="red--text text--lighten-2">キモチ</strong>の人がいて、そこに気づくことができたのなら。</p>
          </v-flex>
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>

  <v-card class="elevation-0">
    <v-card-text class="headline">
      <v-row>
        <v-flex offset-xs1>
          <v-flex xs10>
            <p>もっとスムーズに仕事ができるかもしれない。</p>
            <p>もっと仲良くなれるかもしれない。</p>
            <p>もっと自分の<strong class="red--text text--lighten-2">キモチ</strong>を知ってもらえるかもしれない。</p>
            <p class="display-2 red--text text--lighten-2">きっと、もっと、チームになれる。</p>
          </v-flex>
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>

  <v-card color="grey lighten-4" class="elevation-0">
    <v-card-text class="headline text-xs-right">
      <v-row>
        <v-flex xs11>
          <v-flex xs10 offset-xs2>
            <p><strong class="red--text text--lighten-2">キモチ</strong>が見えるツールが生み出すコミュニケーションを。</p>
            <p class="display-2">複雑な<strong class="red--text text--lighten-2">キモチ</strong>を、もっとシンプルに。</p>
          </v-flex>
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>

  <v-card class="elevation-0">
    <v-card-text class="headline text-xs-center">
      <v-row>
        <v-flex offset-xs1>
          <v-flex xs10>
            <p><strong class="red--text text--lighten-2">キモチ</strong>でつながるアプリ</p>
            <p class="display-4">ニコカレ。</p>
            <v-btn outline large color="primary" href="/login" class="headline">始めてみよう</v-btn>
          </v-flex>
        </v-flex>
      </v-row>
    </v-card-text>
  </v-card>
@endsection